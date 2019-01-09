<?php
/**
 * Created by PhpStorm.
 * User: minhao
 * Date: 2016-06-16
 * Time: 16:53
 */

namespace GoldSdk\Api\Middlewares\Renderers;

use GoldSdk\Api\Middlewares\CaughtExceptionInfo;
use Symfony\Component\HttpFoundation\Response;

interface RendererInterface
{
    /**
     * Take the unformatted result and return a Response object
     *
     * @param $unformattedResult
     *
     * @return Response
     */
    public function renderOnSuccess($unformattedResult);

    /**
     * Take the caught exception info object and return a Response object
     *
     * @param CaughtExceptionInfo $info
     *
     * @return Response
     */
    public function renderOnException(CaughtExceptionInfo $info);
}
