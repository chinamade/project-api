<?php
/**
 * Created by PhpStorm.
 * User: lbc
 * Date: 2016-05-05
 * Time: 14:58
 */

namespace GoldSdk\Api\Middlewares;

use Oasis\Mlib\Utils\StringUtils;
use GoldSdk\Api\Api;
use GoldSdk\Api\Middlewares\Renderers\ApiRenderer;
use GoldSdk\Api\Middlewares\Renderers\PanelApiRenderer;
use GoldSdk\Api\Middlewares\Renderers\PanelLoginRenderer;
use GoldSdk\Api\Middlewares\Renderers\RendererInterface;
use GoldSdk\Api\Security\PanelSecurity\SignedRequestSender;
use Symfony\Component\HttpFoundation\Request;

class FallbackViewHandler
{
    /**
     * @var Api
     */
    protected $Api;
    
    public function __construct(Api $Api)
    {
        $this->Api = $Api;
    }
    
    function __invoke($result, Request $request)
    {
        $route = $request->get('_route');
        switch (true) {
            case StringUtils::stringStartsWith($route, 'panellogin'): {
                /** @var RendererInterface $renderer */
                $renderer = new PanelLoginRenderer();
                break;
            }
            case StringUtils::stringStartsWith($route, 'panel-api'): {
                /** @var SignedRequestSender $sender */
                $sender = $this->Api->getHttpKernel()->getUser();
                if ($sender) {
                    $access_token = $sender->getNewAccessToken();
                }
                else {
                    $access_token = '';
                }
                /** @var RendererInterface $renderer */
                $renderer = new PanelApiRenderer($access_token);
                break;
            }
            default:
                /** @var RendererInterface $renderer */
                $renderer = new ApiRenderer();
            
        }
        
        if ($result instanceof CaughtExceptionInfo) {
            mtrace($result->getException(), "Fallback handling exception: ", 400);
            
            return $renderer->renderOnException($result);
        }
        else {
            return $renderer->renderOnSuccess($result);
        }
    }
}
