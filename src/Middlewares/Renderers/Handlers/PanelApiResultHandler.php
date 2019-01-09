<?php
/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2017/8/18
 * Time: 17:26
 */

namespace GoldSdk\Api\Middlewares\Renderers\Handlers;

use GoldSdk\Api\Api;
use GoldSdk\Api\Exceptions\ErrorCodeHandler;
use GoldSdk\Api\Middlewares\CaughtExceptionInfo;
use Symfony\Component\HttpFoundation\Response;

class PanelApiResultHandler implements \JsonSerializable
{
    /** @var array */
    private $header = [];
    /** @var array */
    private $body = [];
    /** @var int */
    protected $status_code = Response::HTTP_OK;
    /** @var  string */
    protected $status = 'success';
    /** @var  int */
    protected $code = Response::HTTP_OK;
    /** @var  string */
    protected $msg_key = '';
    /** @var  string */
    protected $msg = 'success';
    /** @var bool */
    protected $is_dev = false;
    /** @var array */
    protected $token = [];
    
    public function __construct($result)
    {
        $this->setIsDev();
        if ($result instanceof CaughtExceptionInfo) {
            $this->setStatusCode($result->getCode());
            $this->setStatus('fail');
            $this->setCode($result->getErrorCode());
            $this->setMsgKey();
            $this->setMsg($result->getException()->getMessage());
            $this->setBody([]);
        }
        else {
            $this->setBody($result);
        }
    }
    
    public function __toArray()
    {
        $this->setHeader(
            [
                'is_dev'      => $this->isIsDev(),
                'status_code' => $this->getStatusCode(),
                'status'      => $this->getStatus(),
                'code'        => $this->getCode(),
                'msg_key'     => $this->getMsgKey(),
                'msg'         => $this->getMsg(),
                'token'       => $this->getToken(),
                'version'     => Api::app()->getParameter('version'),
            ]
        );
        
        $res = [
            "header" => $this->getHeader(),
            'body'   => $this->getBody(),
        ];
        
        return $res;
    }
    
    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->__toArray();
    }
    
    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    /**
     * @param array $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }
    
    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @param array $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }
    
    /**
     * @param int $status_code
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
    }
    
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * @return string
     */
    public function getMsgKey()
    {
        return $this->msg_key;
    }
    
    /**
     * setMsgKey
     */
    public function setMsgKey()
    {
        $this->msg_key = ErrorCodeHandler::info($this->getCode());
    }
    
    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }
    
    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }
    
    /**
     * @return boolean
     */
    public function isIsDev()
    {
        return $this->is_dev;
    }
    
    /**
     *
     */
    public function setIsDev()
    {
        $app          = Api::app();
        $this->is_dev = $app->isDebug();
    }
    
    /**
     * @return array
     */
    public function getToken()
    {
        if (!$this->token) {
            $this->setToken('');
        }
        
        return $this->token;
    }
    
    /**
     * @param $access_token
     */
    public function setToken($access_token)
    {
        $this->token = [
            'access_token' => $access_token,
        ];
    }
    
}
