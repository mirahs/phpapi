<?php
require_once __DIR__ . '/../vendor/autoload.php';


// 是否调试
define('APP_DEBUG', true);
// 根目录
define('PATH_ROOT', __DIR__ . '/../');
// 路由目录
define('PATH_ROUTE',PATH_ROOT . 'route/');

(new \core\App())->run();
