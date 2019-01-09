<?php

/**
 * Created by PhpStorm.
 * User: Baihuzi
 * Date: 2017/8/21
 * Time: 11:51
 */
namespace GoldSdk\Api\Exceptions;

class ErrorCodeHandler
{
    /** Panel-Game-Base */
    const BASE_INF0             = 11100;
    const SERVERLIST_INFO       = 11200;
    const SERVERLIST_NOT_EXIST  = 11201;
    const GAMEVERSION_INFO      = 11300;
    const GAMEVERSION_NOT_EXIST = 11301;
    const GAMEVERSION_INVALID   = 11302;
    const GAMEVERSION_EXIST     = 11303;
    const PLAN_INFO             = 11400;
    const LINK_INFO             = 11500;
    const LINK_NOT_EXIST        = 11501;
    const LINK_NOT_CONFIGED     = 11502;
    /** Panel-SDK-Modle-Base */
    const PANEL_SDK_CONFIG                = 12100;
    const PANEL_SDK_CONFIG_EXIST          = 12161;
    const PANEL_SDK_CONFIG_NOT_EXIST      = 12162;
    const PANEL_SDK_CONFIG_FILETYPE_ERROR = 12163;
    const PANEL_SDK_VERSION               = 12101;
    const PANEL_SDK_VERSION_EXIST         = 12102;
    const PANEL_SDK_VERSION_NOT_EXIST     = 12103;
    const PANEL_ADJUSTTOKEN               = 12400;
    const PANEL_ADJUSTTOKEN_EXIST         = 12401;
    const PANEL_ADJUSTTOKEN_NOT_EXIST     = 12401;
    /** Panel-web-site */
    const PANEL_LPCONFIG                   = 13200;
    const PANEL_LPCONFIG_NOT_EXIST         = 13201;
    const PANEL_LPCONFIG_CREATE_ZIP_FALI   = 13209;
    const PANEL_CONTENT                    = 13300;
    const PANEL_CONTENT_CREATE_CTYPE_ERROE = 13301;
    const PANEL_CONTENT_CTYPE_EXIST        = 13302;
    const PANEL_CONTENT_CTYPE_NOT_EXIST    = 13303;
    const PANEL_CONTENT_NOT_EXIST          = 13304;
    const PANEL_CONTENT_CREATE_ERROR       = 13305;
    const PANEL_ACTIVITY_NOT_EXIST         = 13401;
    const PANEL_ACTIVITY_CREATE_ERROR      = 13402;
    const PANEL_GIFT_NOT_EXIT              = 13501;
    const PANEL_GIFT_CREATE_ERROR          = 13502;
    const PANEL_GIFT_UPLOAD_FAIL           = 13503;
    const PANEL_GIFT_FILE_THAN_LIMIT       = 13504;
    const PANEL_GIFT_DEL_FAIL              = 13505;

    /**
     * @param $key
     *
     * @return string
     */
    public static function info($key)
    {
        //there by config file
        $infos = [
            self::SERVERLIST_NOT_EXIST => "serverlist_not_exist",
        ];
        
        return $infos[$key] ? : "error";
    }
}
