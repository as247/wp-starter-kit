<?php

namespace WpStarter\Wordpress\View;

use WpStarter\Contracts\Support\Renderable;

abstract class Component implements Renderable
{
    protected $data=[];
    function setData($data){
        $this->data=$data;
        return $this;
    }
    function mount(){

    }
}