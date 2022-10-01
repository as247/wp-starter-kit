<?php

namespace WpStarter\Wordpress\Response;

use WpStarter\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @mixin View
 */
class Content extends Response
{
    protected $view;
    protected $title;
    public function __construct(View $view)
    {
        parent::__construct();
        $this->view=$view;
    }

    function sendHeaders(){

    }
    function withTitle($title){
        $this->title=$title;
        return $this;
    }
    function getTitle($title=null){
        if($this->title){
            return $this->title;
        }
        return $title;
    }
    function getContent($content=null){
        return $this->view->render();
    }
    public static function make($view = null, $data = [], $mergeData = []){
        return new Content(ws_view($view,$data,$mergeData));
    }
    public function __call(string $name, array $arguments)
    {
        call_user_func_array([$this->view,$name],$arguments);
        return $this;
    }
}