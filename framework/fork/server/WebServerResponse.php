<?php
namespace wafm\framework\fork\server;

use Exception;
use app;

class WebServerResponse 
{
    private $contentLength = -1;
    private $resource = NULL;
    private $mime = '';
    private $requestExtension = '';
    private $requestName = '';
            
    const SEPARATOR = "\n\n";

    /**
     * @param int $code
     * @param string $status
     * @param string $type
     * @return string
     */
    public function header(int $code, string $status, string $type): string
    {
        return implode("\n", [
        
            "HTTP/1.1 $code $status",
            "content-type: $type",
            "connection: close",
            "accept-ranges: bytes",
            "transfer-encoding: deflate",
            "cache-control: public, max-age=86400",
            "X-XSS-Protection: 1; mode=block"
            //"content-length: " . $this->contentLength,
            
        ]) 
        . self::SEPARATOR;
    }

    public function handler(WebServerRequest $request)
    {
        
        $this->requestExtension = $request->getExtension();     
        $this->requestName = $this->getName($request->getLink());
  
        $mimes = $this->registerMIMES();
        
        if(!isset($mimes[$this->requestExtension])) {
            return;
        }

        if($this->requestExtension === 'html' || $this->requestExtension === 'php') {
            $this->resource = WebEnv::PATH_HTML . $request->getLink();
        }          
        else {
            $this->resource = $this->getRouteSource($request->getLink());
        }
        
        $this->mime = $mimes[$this->requestExtension];                   
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
    public function getMime()
    {
        return $this->mime;
    }
    
    public function content()
    {
        
        if($this->requestExtension === 'php' || WebEnv::TEMPLATE)
        {            
            $file = WebTemplateBuilder::get(
                $this->requestName, 
                @file_get_contents($this->resource)
            );
        }
        else 
        {
            $file = @file_get_contents($this->resource);
        }
        
        $path = $this->resource;
        $len = strlen($file);
        $this->contentLength = strlen($file);
        return $file;

    }
    
    public function isEmpty()
    {
        return $this->contentLength === -1;
    }
    
    public function isResource()
    {
        return !is_null($this->resource);
    }
    
    public function errorHandler(int $code = 400, string $status = "Bad Request")
    {
        return implode("\n", [
        
            "HTTP/1.1 $code $status",
            "Connection: close",
            "Transfer-Encoding: deflate",
            
        ]) 
        . self::SEPARATOR;      
    }
    
    public function clear()
    {
        $this->resource = NULL;
    }
    
    private function registerMIMES(): array
    {
        return [
            'html'  => 'text/html; charset=UTF-8',
            'php'   => 'text/html; charset=UTF-8',
            'css'   => 'text/css; charset=UTF-8',
            'js'    => 'text/javascript',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'png'   => 'image/png',
            'ico'   => 'text/html; charset=UTF-8',
            'woff'  => 'application/font-woff',
            'woff2' => 'application/font-woff',
            'ttf'   => 'application/x-font-ttf',
        ];
    }
    
    private function getName(string $link)
    {        
        preg_match("/([a-z0-9\.\_\-]+)\.(html|php)$/", $link, $matcher);        
        if(count( $matcher ) <= 1){
            return NULL;
        }
        return strtolower(str_replace(['.','-','_'], "", $matcher[1]));
    }
    
    private function getRouteSource(string $link)
    {                       
        $link = (WebEnv::GUI_FRAMEWORK && preg_match("/^\/gui\/(". WebEnv::GUI_NAME . ")", $link)) 
            ? WebEnv::PATH_GUI . str_replace("\/gui", '', $link)
            : WebEnv::PATH_RESOURCE . $link;
        return $link; 
    }
}
