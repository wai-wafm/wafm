<?php
namespace wafm\framework\fork\template;

use app;

final class WebTemplateBuilder
{
    public static function get(string $name, $resource)
    {              
        $controller = WebEnv::TEMPLATE;
        $trans = new ScriptTransaction();
        $trans->setMethod($name);     
        $vars = $trans->getVars(); 
        foreach ($vars as $k=>$v){
            $v = $controller ? $v : '';
            $resource = str_replace('{{@:$'.$k.'}}', $v, $resource);
        }
        return $resource;
    }
}