<?php
namespace wafm\framework\fork\server;

use app;
use std;

/**
 * Class WebServerHelper
 * @package wafm\framework\fork\server
 */
class WebServerHelper 
{
    /**
     * @var ServerSocket
     */
    protected static $socket = NULL;
    /**
     *
     */
    protected static function socket()
    {
        if(self::$socket !== NULL) {
            WebServerError::alreadyStarted();
        }
        
        self::$socket = new ServerSocket(WebEnv::PORT, WebEnv::HOST);
        /*@deprecated slow execution speed*/
        /*self::$socket->bind(WebEnv::HOST, WebEnv::PORT);*/
    }

    /**
     * @return ServerSocket
     */
    public static function getSocket(): ServerSocket
    {
        return self::$socket;
    }
}