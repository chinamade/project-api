<?php
/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:40
 */
 
 
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use GoldSdk\Api\Database\ApiDatabase;

require_once __DIR__ . "/../bootstrap.php";

return ConsoleRunner::createHelperSet(ApiDatabase::getEntityManager());
