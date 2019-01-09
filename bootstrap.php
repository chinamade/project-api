<?php
/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:41
 */

use GoldSdk\Api\Api;
use GoldSdk\Api\ApiConfiguration;

require_once __DIR__ . "/vendor/autoload.php";

define('PROJECT_DIR', __DIR__);

/** @var Api $app */
$app = Api::app();
$app->init(__DIR__ . "/config", new ApiConfiguration(), __DIR__ . "/cache/config");

return $app;

