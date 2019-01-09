<?php
/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:40
 */

namespace GoldSdk\Api\Database;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use GoldSdk\Api\Api;

class ApiDatabase
{
    public static function getEntityManager()
    {
        static $entityManager = null;
        if ($entityManager instanceof EntityManager) {
            return $entityManager;
        }
        
        $app = Api::app();
        
        $isDevMode = $app->isDebug();
        $config    = Setup::createAnnotationMetadataConfiguration(
            [PROJECT_DIR . "/src/Entities"],
            $isDevMode,
            $app->getParameter('app.dir.data') . "/proxies",
            null,
            false /* do not use simple annotation reader, so that we can understand annotations like @ORM/Table */
        );
        $config->addEntityNamespace("Api", "GoldSdk\\Api\\Entities");
        //$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        
        $conn           = $app->getParameter('app.db');
        $conn["driver"] = "pdo_mysql";
        $entityManager  = EntityManager::create($conn, $config);
        
        return $entityManager;
    }
    
}
