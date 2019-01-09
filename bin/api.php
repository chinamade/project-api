#! /usr/bin/env php
<?php
/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:41
 */


use GoldSdk\Api\Api;

/** @var Api $app */
$app = require_once __DIR__ . "/../bootstrap.php";

$app->getConsoleApplication()->run();

