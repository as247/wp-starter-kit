<?php

namespace WpStarter\Wordpress\Response;

use Symfony\Component\HttpFoundation\Response;
use WpStarter\Contracts\View\View;

class Shortcode extends Response
{
    /**
     * @var View[]
     */
    protected $shortcodes=[];
    protected $title;
    public function __construct($tag,View $view)
    {
        parent::__construct();
        $this->shortcodes[$tag]=$view;
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
    function all(){
        return $this->shortcodes;
    }
    /**
     * @param $tag
     * @return View|null
     */
    function view($tag){
        return $this->shortcodes[$tag]??null;
    }

    /**
     * @param $tag
     * @param $view
     * @return mixed|View
     */
    function add($tag, $view, $data = [], $mergeData = []){
        if(is_string($view)){
            $view=ws_view($view,$data, $mergeData);
        }
        return $this->shortcodes[$tag]=$view;
    }

    /**
     * @param $shortcode
     * @param $view
     * @param $data
     * @param $mergeData
     * @return static
     */
    public static function make($tag, $view, $data = [], $mergeData = []){
        if(is_string($view)){
            $view=ws_view($view,$data,$mergeData);
        }
        return new static($tag,$view);
    }
}