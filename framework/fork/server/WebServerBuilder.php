<?php
namespace wafm\framework\fork\server;

use std;
use app;

/**
 * Class WebServerBuilder
 * @package wafm\framework\fork\server
 */
final class WebServerBuilder extends WebServerHelper
{    
    /**
     * @return void
     */
    public static function run(): void
    {
        parent::socket();
        $thread = new Thread(function(){
            $server     = WebServerBuilder::getSocket();
            $request    = new WebServerRequest();
            $response   = new WebServerResponse();
                
            while($client = $server->accept()) {
                 $request->handler($client->getInput()->read(1024));
                 $response->handler($request); 
                  if($response->isResource()){
                     $client->getOutput()->write($response->header(200, 'OK', $response->getMime()));
                     $client->getOutput()->write($response->content());                     
                 }            
                 else {
                     $client->getOutput()->write($response->errorHandler());
                 } 
                 $response->clear();            
                 $client->close();
            }
        });
        
        $thread->start();
        
    }
}