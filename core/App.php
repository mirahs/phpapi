<?php
namespace core;


class App {
    public function __construct() {
        error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED);

        // 调试模式
        if (APP_DEBUG) {
            ini_set('display_errors','On');

            $whoops = new \Whoops\Run();
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
            $whoops->register();
        } else {
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', PATH_LOG . 'php_errors.log');
        }
        ini_set('date.timezone','Asia/Shanghai');
    }


    /**
     * 执行应用程序
     */
    public function run(): void {
        $router     = new Router();
        $request    = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], Helper::getallheaders());
        $response   = new Response();

        $response->setContent($router->dispatch($request))->send();
    }
}
