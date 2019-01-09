<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/4/18
 * Time: 15:37
 */

namespace GoldSdk\Api\Security;

use Oasis\Mlib\Http\ServiceProviders\Cors\CrossOriginResourceSharingStrategy;

class CorsStrategy extends CrossOriginResourceSharingStrategy
{
    public function isOriginAllowed($origin)
    {
        return parent::isOriginAllowed($origin);
    }
}