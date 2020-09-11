<?php
namespace wafm\framework\fork\server;

final class WebServerError 
{    
    public static function alreadyStarted()
    {
        alert("Error: WepApp Already Started");
        exit;
    }
}