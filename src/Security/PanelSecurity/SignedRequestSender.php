<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2018/4/20
 * Time: 15:09
 */

namespace GoldSdk\Api\Security\PanelSecurity;

use Symfony\Component\Security\Core\User\UserInterface;

class SignedRequestSender implements UserInterface
{
    protected $uid;
    protected $roles;
    protected $token;
    
    public function __construct($uid, $roles, $token)
    {
        $this->uid   = $uid;
        $this->roles = $roles;
        $this->token = $token;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
    
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        throw  new \LogicException(__FUNCTION__ . " is not supported in " . static::class);
    }
    
    public function getUsername()
    {
        // TODO: Implement getPassword() method.
        throw  new \LogicException(__FUNCTION__ . " is not supported in " . static::class);
    }
    
    public function getSalt()
    {
        // TODO: Implement getPassword() method.
        throw  new \LogicException(__FUNCTION__ . " is not supported in " . static::class);
    }
    
    public function eraseCredentials()
    {
        
    }
    
    public function getNewAccessToken()
    {
        return $this->token;
    }
    
    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }
    
    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }
    
}