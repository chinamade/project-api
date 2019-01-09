<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/4/20
 * Time: 15:09
 */

namespace GoldSdk\Api\Security\PanelSecurity;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Oasis\Mlib\Http\ServiceProviders\Security\AbstractSimplePreAuthenticateUserProvider;
use GoldSdk\Api\Api;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SignedRequestSenderProvider extends AbstractSimplePreAuthenticateUserProvider
{
    /**
     * @var array
     */
    private $app;
    
    public function __construct()
    {
        parent::__construct(SignedRequestSender::class);
    }
    
    public function authenticateAndGetUser($credentials)
    {
        list($ip, $jwt_access) = $credentials;
        $parser         = new Parser();
        $validationData = new ValidationData();
        try {
            $token = $parser->parse($jwt_access);
            
            if (!$token->validate($validationData)
                || !$token->verify(new Sha256(), $this->app['appsecret'])
            ) {
                if (!Api::app()->isDebug()) {
                    throw new AccessDeniedHttpException("Invalid Logged In Token: verification failed!");
                }
            }
        } catch (\Exception $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        }
        
        try {
            $appid = $token->getClaim('appid');
            $roles = $token->getClaim('roles');
            $uid   = $token->getClaim('uid');
        } catch (\Exception $e) {
            throw new AccessDeniedHttpException("Requested claim is not provided in JWT Token");
        }
        
        if ($appid != $this->app['appid']) {
            throw new AccessDeniedHttpException("Invalid appId In Token: verification failed!");
        }
        
        $sysRoles = ['ADMIN', 'USER', 'DEV'];
        
        $validRoles = array_filter(
            $roles,
            function ($roleCode) use ($sysRoles) {
                return preg_match('#^ROLE_APP_[A-Za-z0-9]+_SYS_(' . implode('|', $sysRoles) . ')#', $roleCode);
            }
        );
        
        if (!sizeof($validRoles)) {
            throw new AccessDeniedHttpException("Invalid Roles In Token: verification failed!");
        }
        
        $sender = new SignedRequestSender($uid, $roles, $jwt_access);
        
        return $sender;
    }
    
}