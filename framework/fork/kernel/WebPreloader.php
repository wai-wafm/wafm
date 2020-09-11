<?php
namespace wafm\framework\fork\kernel;

use app;

final class WebPreloader extends ListClassPreloader
{    
    public function __construct()
    {
        foreach ($this->list as $clazz) {
            new $clazz;
        }
    }
}