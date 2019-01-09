<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/4/20
 * Time: 15:09
 */

namespace GoldSdk\Api\Security\PanelSecurity;

use Oasis\Mlib\Http\ServiceProviders\Security\AbstractSimplePreAuthenticationPolicy;

class SignedRequestPolicy extends AbstractSimplePreAuthenticationPolicy
{
    public function getPreAuthenticator()
    {
        return new SignedRequestAuthenticator();
    }
}