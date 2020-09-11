<?php
namespace wafm\framework\fork\template;

use app;

class WebTransactionHelper 
{
    protected $method = NULL;
    
    final public function setMethod(string $method)
    {
        $this->method = $method;
    }
    
    final public function getVars(): array
    {              
        if(empty($this->method)) {
            return [];
        }
            
        if(!method_exists(ScriptTransaction::class, $this->method)) {
            return [];
        }
        return $this->{$this->method}();
    }
}