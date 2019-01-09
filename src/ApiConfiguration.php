<?php

namespace GoldSdk\Api;

use Oasis\Mlib\Utils\StringUtils;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Created by SlimApp.
 *
 * Date: 2019-01-07
 * Time: 10:40
 */
class ApiConfiguration implements ConfigurationInterface
{
    
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root        = $treeBuilder->root('app');
        {
            $root->children()->booleanNode('is_debug')->defaultValue(true);
            $dir = $root->children()->arrayNode('dir');
            {
                $makeAbsolute = function ($path) {
                    return StringUtils::stringStartsWith($path, \DIRECTORY_SEPARATOR)
                        ? $path
                        : \PROJECT_DIR . \DIRECTORY_SEPARATOR . $path;
                };
                
                $dir->children()->scalarNode('log')->beforeNormalization()->always($makeAbsolute);
                $dir->children()->scalarNode('data')->beforeNormalization()->always($makeAbsolute);
                $dir->children()->scalarNode('cache')->beforeNormalization()->always($makeAbsolute);
                $dir->children()->scalarNode('template')->beforeNormalization()->always($makeAbsolute);
            }
            
            $db = $root->children()->arrayNode('db');
            {
                $db->children()->scalarNode('host')->isRequired();
                $db->children()->integerNode('port')->defaultValue(3306);
                $db->children()->scalarNode('user')->isRequired();
                $db->children()->scalarNode('password')->isRequired();
                $db->children()->scalarNode('dbname')->isRequired();
            }
            $subdomains = $root->children()->arrayNode('subdomains');
            {
                $subdomains->children()->scalarNode('api')->isRequired();
            }
            $panel = $root->children()->arrayNode('panel');
            {
                $panel->children()->scalarNode('token_name')->isRequired();
            }
            $sns = $root->children()->arrayNode('sns');
            {
                $facebook = $sns->children()->arrayNode('facebook');
                {
                
                }
                $twitter = $sns->children()->arrayNode('twitter');
                {
                
                }
                $google = $sns->children()->arrayNode('google');
                {
                
                }
                $gamecenter = $sns->children()->arrayNode('gamecenter');
                {
                
                }
            }
            $pay = $root->children()->arrayNode('pay');
            {
                $apple_pay = $pay->children()->arrayNode('apple_pay');
                {
                    $apple_pay->children()->booleanNode('debug')->defaultTrue();
                }
            }
            
        }
        
        return $treeBuilder;
    }
}

