<?php

namespace App\Component;

use WpStarter\Wordpress\View\Component;

class HelloComponent extends Component
{
    function mount()
    {

    }

    public function render()
    {

        return 'render component: Page title: '.get_the_title();
    }
}