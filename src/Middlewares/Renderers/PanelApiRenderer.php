<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2017/8/18
 * Time: 15:57
 */

namespace GoldSdk\Api\Middlewares\Renderers;

use GoldSdk\Api\Middlewares\CaughtExceptionInfo;
use GoldSdk\Api\Middlewares\Renderers\Handlers\PanelApiResultHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class PanelApiRenderer implements RendererInterface
{
    /** @var  string */
    protected $access_token;
    
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }
    
    /**
     * Take the unformatted result and return a Response object
     *
     * @param $result
     *
     * @return Response
     */
    public function renderOnSuccess($result)
    {
        if (!is_array($result)) {
            $result = ['result' => $result];
        }
        $resultHandler = new PanelApiResultHandler($result);
        $resultHandler->setToken($this->access_token);
        
        return new JsonResponse($resultHandler);
        
    }
    
    /**
     * Take the caught exception info object and return a Response object
     *
     * @param CaughtExceptionInfo $info
     *
     * @return Response
     */
    public function renderOnException(CaughtExceptionInfo $info)
    {
        $resultHandler = new PanelApiResultHandler($info);
        $resultHandler->setToken($this->access_token);
        
        return new JsonResponse($resultHandler);
    }
}
