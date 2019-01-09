<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2017/8/19
 * Time: 15:21
 */

namespace GoldSdk\Api\Middlewares\Renderers;

use GoldSdk\Api\Middlewares\CaughtExceptionInfo;
use GoldSdk\Api\Middlewares\Renderers\Handlers\PanelApiResultHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class PanelLoginRenderer implements RendererInterface
{
    
    public function renderOnSuccess($result)
    {
        
        if (!is_array($result)) {
            $result = ['result' => $result];
        }
        $resultHandler = new PanelApiResultHandler($result);
        $resultHandler->setToken($result['result']['access_token']);
        
        return new JsonResponse($resultHandler);
        
    }
    
    public function renderOnException(CaughtExceptionInfo $info)
    {
        $resultHandler = new PanelApiResultHandler($info);
        $resultHandler->setToken('');
        
        return new JsonResponse($resultHandler);
    }
}
