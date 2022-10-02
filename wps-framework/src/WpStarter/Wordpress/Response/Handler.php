<?php

namespace WpStarter\Wordpress\Response;

use WpStarter\Contracts\Http\Kernel;
use WpStarter\Http\Request;
use WpStarter\Wordpress\Contracts\HasGetTitle;
use WpStarter\Wordpress\Response;

class Handler
{
    /**
     * @var Kernel
     */
    protected $kernel;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    function handle(Kernel $kernel,Request $request,Response $response){
        $this->kernel=$kernel;
        $this->request=$request;
        $this->response=$response;
        $response->mountComponent();
        $response->sendHeaders();//Header should be sent as soon as possible
        if($response instanceof HasGetTitle) {
            add_filter('the_title', function ($content) use ($response) {
                return $response->getTitle($content);
            });
        }
        if($response instanceof Page){
            list($hook,$priority)=$response->getHook();
            if(!$hook || did_action($hook)) {
                $this->sendResponseAndDie();
            }else{
                add_action($hook,[$this,'sendResponseAndDie'],$priority);
            }
        }else {
            if ($response instanceof Content) {
                add_filter('the_content', function ($content) use ($response) {
                    return $response->getContent($content);
                });
            } elseif ($response instanceof Shortcode) {
                foreach ($response->all() as $tag => $view) {
                    add_shortcode($tag, function () use ($view) {
                        return $view->render();
                    });
                }
            }
            $this->registerTerminateOnShutdown();
        }
    }
    protected function registerTerminateOnShutdown(){
        add_action('wp_shutdown',[$this,'terminate']);
    }
    public function terminate(){
        $this->kernel->terminate($this->request, $this->response);
    }
    function sendResponseAndDie(){
        $this->response->send();
        $this->kernel->terminate($this->request, $this->response);
        die;
    }
}