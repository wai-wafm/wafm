<?php
namespace wafm\framework\fork\kernel;

use gui;
use app;

class WebProvider 
{
    private static $engine = NULL;
    
    public function __construct()
    {
        if(self::$engine === NULL) {
            self::$engine = app()
                ->form(WebEnv::MAIN_FORM_NAME)
                ->{WebEnv::MAIN_FORM_ID}
                ->engine;
        }
    }
    
    /**
     * @return UXWebEngine
     */
    public static function engine(): UXWebEngine
    {
        return self::$engine;
    }
}