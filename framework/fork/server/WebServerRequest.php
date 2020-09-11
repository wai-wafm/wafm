<?php
namespace wafm\framework\fork\server;

class WebServerRequest 
{    
    /**
     * @var string
     */
    private $method = '';
    /**
     * @var string
     */
    private $link = '';
    /**
     * @var string
     */
    private $query = '';

    /**
     * @param string $input
     */
    public function handler($input): void
    {
        $line = explode(" ", explode("\n", $input)[0]);
        $this->method = $line[0];
        $link = explode("?", $line[1]);
        $this->link = str_replace(['./','../'], '/', $link[0]);
        $this->query = $this->parseQuery($link[1]);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
    
    public function getExtension(): string
    {
        $ext = explode(".", $this->link);
        $index = count($ext) - 1;
        return strtolower(!isset($ext[$index]) ? 'html' : $ext[$index]);
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->query;
    }
    
    private function parseQuery(string $query)
    {    
        $parse = [];
        $params = explode("&", $query);
        foreach ($params as $p){
            $ex = explode("=", $p);
            $parse[$ex[0]] = $ex[1];
        }
        return $parse;
    }
}


