<?php
namespace wafm\app\php;

use app;

class ScriptTransaction extends WebTransactionHelper
{
    public function template()
    {        
        return 
        [
            "a" => 1
        ];
    }
    
    public function readme()
    {        
        return 
        [
            "readme" => @file_get_contents('res://wafm/README.md')
        ];
    }
}