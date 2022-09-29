<?php
/***
 * Plugin name: Swire
 * Version:     6.0.20
 * Description: Main plugin for swire
 * Author:      Arestos
 * Author URI:  https://arestos.com
 *
 */
if(defined('__WS_FILE__')){
    return ;
}
define('WS_VERSION', '6.0.20');
define('WS_DIR', __DIR__);
define('__WS_FILE__', __FILE__);

require __DIR__ . '/bootstrap/autoload.php';
use WpStarter\Http\Request;
use WpStarter\Contracts\Http\Kernel;
final class SW_MAIN
{
	protected $sw;
	static protected $instance;

	public static function make()
	{
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	function __construct()
	{
		$this->sw = require_once __DIR__ . '/bootstrap/app.php';
	}

	function run()
	{
		if ($this->isRunningInConsole()) {
			$this->runCli();
		} else {
			$this->runWeb();
		}
	}

	protected function isRunningInConsole(){
        if(defined('SW_CLI') && SW_CLI){
            return true;
        }
        if(defined('WP_CLI') && WP_CLI){
            return true;
        }
        if (isset($_ENV['APP_RUNNING_IN_CONSOLE'])) {
            return $_ENV['APP_RUNNING_IN_CONSOLE'] === 'true';
        }
        if(defined('SW_WEB_REQUEST') && SW_WEB_REQUEST){//Force web request
            return false;
        }
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

	protected function runCli()
	{
		$kernel = $this->sw->make(WpStarter\Contracts\Console\Kernel::class);
        //add_action('sw_early_bootstrap',[$kernel,'earlyBootstrap'],0);
		add_action('plugins_loaded',[$kernel,'bootstrap'], 1);
		if(defined('WS_CLI') && WS_CLI) {//We have wp cli and sw cli, only actual run ws cli on ws cli
            add_action('init', function () use ($kernel) {
                $status = $kernel->handle(
                    $input = new Symfony\Component\Console\Input\ArgvInput,
                    new Symfony\Component\Console\Output\ConsoleOutput
                );
                $kernel->terminate($input, $status);

                exit($status);
            }, 110);
        }
        do_action('sw_early_bootstrap');
	}


	protected function runWeb()
	{
        $kernel = $this->sw->make(WpStarter\Contracts\Http\Kernel::class);
        add_action('plugins_loaded',[$kernel,'bootstrap'], 1);
	    add_action('init', function ()use($kernel) {

            $response = $kernel->handle(
                $request = Request::capture()
            );
            if($request->route()){//A route matched
                if($response instanceof \WpStarter\Wordpress\Response){
                    $response->sendHeaders();
                    add_filter('the_content',function()use($response){
                        return $response->getContent();
                    });
                    $kernel->terminate($request, $response);
                }else {
                    $response->send();
                    $kernel->terminate($request, $response);
                }


            }
		}, 1);
        do_action('sw_early_bootstrap');

	}
}
if(!wp_installing()) {
    SW_MAIN::make()->run();
}

