<?php
namespace wafm\framework\fork\config;

use bundle\preg\Preg;
use app;

class ListClassPreloader 
{
    protected $list = [
        Preg::class,
        WebProvider::class,
        WebTemplateBuilder::class,
        ScriptTransaction::class
    ];
}