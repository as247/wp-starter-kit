<?php
use WpStarter\Wordpress\Response\Content;
if (! function_exists('wp_view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \WpStarter\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \WpStarter\Wordpress\Response\Content
     */
    function wp_view($view = null, $data = [], $mergeData = [])
    {
        return Content::make($view, $data, $mergeData);
    }
}
