<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2017/8/19
 * Time: 11:13
 */

namespace GoldSdk\Api\Middlewares;

use Oasis\Mlib\Http\Middlewares\MiddlewareInterface;
use Oasis\Mlib\Http\SilexKernel;
use Oasis\Mlib\Utils\StringUtils;
use GoldSdk\Api\Api;
use GoldSdk\Api\Middlewares\AccessDecisions\PanelApiAccessDecision;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccessDecisionMiddleware implements MiddlewareInterface
{
    /**
     * @return bool
     */
    public function onlyForMasterRequest()
    {
        return true;
    }
    
    public function after(Request $request, Response $response)
    {
    }
    
    public function before(Request $request, Application $application)
    {
        date_default_timezone_set('Asia/Shanghai');
        $route = $request->get('_route');
        
        switch (true) {
            case StringUtils::stringStartsWith($route, 'panel-api'):
                {
                    
                    $accessDecision = new PanelApiAccessDecision($request, $application);
                    $accessDecision->accessRoles();
                }
                break;
            case StringUtils::stringStartsWith($route, 'sdk'):
                {
                    $version        = $request->attributes->get('version');
                    $versionMapping = Api::app()->getParameter('apisdk-verion-mapping');
    
                    if ($version) {
                        $versionMapping[$version] = $versionMapping[$version] ? : '';
                        $controller               = $request->attributes->get('_controller');
                        $tmp                      = explode('\\', $controller);
        
                        if(!$versionMapping[$version]){
                            throw new NotFoundHttpException('Request Version Not Found');
                        }

                        foreach ($tmp as &$item) {
                            if ($item == 'V1_0') {
                                $item = $versionMapping[$version];
                                break;
                            }
                        }
        
                        $controller               = implode('\\', $tmp);
                    }
    
                    $request->attributes->set('_controller', $controller);
                }
                break;
            default:
            
        }
    }
    
    public function getAfterPriority()
    {
        return false;
    }
    
    public function getBeforePriority()
    {
        return SilexKernel::LATE_EVENT;
    }
}
