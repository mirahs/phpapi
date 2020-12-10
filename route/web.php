<?php
use core\Router;


/** @var Router $router */
$router->get('/hello', function () {
    return '你在访问 web hello';
});
$router->get('/controller', 'app\web\User@index')->middleware(\app\middleware\Web::class);
