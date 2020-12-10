<?php
use core\Router;


/** @var Router $router */
$router->group([
    'namespace' => 'app\api',
    'prefix' => 'api'
], function (Router $router) {
    $router->get('/hello', function () {
        return '你在访问 api hello';
    })->middleware(\app\middleware\Web::class);
});
