<?php
use WpStarter\Wordpress\Response\Content;
use WpStarter\Wordpress\Response\Shortcode;
if (! function_exists('wp_view')) {
    /**
     * Get the post content view
     *
     * @param  string  $view
     * @param  \WpStarter\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \WpStarter\Wordpress\Response\Content
     */
    function wp_view($view, $data = [], $mergeData = [])
    {
        return Content::make($view, $data, $mergeData);
    }
}

if (! function_exists('shortcode_view')) {
    /**
     * Get the shortcode view
     *
     * @param  string  $tag
     * @param  string  $view
     * @param  \WpStarter\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \WpStarter\Wordpress\Response\Shortcode
     */
    function shortcode_view($tag, $view, $data = [], $mergeData = [])
    {
        return Shortcode::make($tag, $view, $data, $mergeData);
    }
}
