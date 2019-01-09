<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/4/20
 * Time: 15:08
 */

namespace GoldSdk\Api\Security\PanelSecurity;

use Oasis\Mlib\Http\ServiceProviders\Security\AbstractSimplePreAuthenticator;
use GoldSdk\Api\Api;
use GoldSdk\Api\Common\CommonFunc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SignedRequestAuthenticator extends AbstractSimplePreAuthenticator
{
    public $tokenName;
    
    public function __construct()
    {
        $this->tokenName = Api::app()->getParameter('app.panel.token_name');
    }
    
    public function getCredentialsFromRequest(Request $request)
    {
        if ($request->query->has($this->tokenName)) {
            $jwtString_access = $request->query->get($this->tokenName);
        }
        elseif ($request->request->has($this->tokenName)) {
            $jwtString_access = $request->request->get($this->tokenName);
        }
        elseif ($request->headers->has($this->tokenName)) {
            $jwtString_access = $request->headers->get($this->tokenName);
        }
        elseif ($request->cookies->has($this->tokenName)) {
            $jwtString_access = $request->cookies->get($this->tokenName);
        }
        else {
            throw new AccessDeniedHttpException("Access JWT Token string not found in request!");
        }
        
        $ip = $request->getClientIps();
        
        return [$ip, $jwtString_access];
    }
}