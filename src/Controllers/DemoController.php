<?php
/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:41
 */

namespace GoldSdk\Api\Controllers;

use Symfony\Component\HttpFoundation\Response;

class DemoController
{
    public function testAction()
    {
        return new Response('Hello World!');
    }
}

