<?php
namespace core;


class Router {
    private $routes     = [];
    private $routeIndex = '';
    private $currGroup  = [];


    public function __construct() {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $router = $this;
        foreach (glob(PATH_ROUTE . '*.php') as $routeFile) {
            /** @noinspection PhpIncludeInspection */
            require_once $routeFile;
        }
    }


    public function group($attributes, \Closure $cb) {
        $this->currGroup[] = $attributes;
        call_user_func($cb, $this);
        array_pop($this->currGroup);
    }

    public function route($method, $uri, $cb) {
        $prefix = '';
        $middleware = [];
        $namespace = '';
        $this->addSlash($uri);

        foreach ($this->currGroup as $group) {
            $prefix .= $group['prefix'] ?? '';
            $middleware = array_merge($middleware, $group['middleware'] ?? []);
            $namespace .= $group['namespace'] ?? '';
        }

        if ($prefix) $this->addSlash($prefix);
        $method = strtoupper($method);
        $uri = $prefix . $uri;
        $this->routeIndex = $method . $uri;
        $this->routes[ $this->routeIndex ] = [
            'method' => $method,
            'uri' => $uri,
            'action' => [
                'cb' => $cb,
                'middleware' => $middleware,
                'namespace' => $namespace,
            ]
        ];
    }

    public function get($uri, $cb) {
        $this->route('get', $uri, $cb);
        return $this;
    }

    public function post($uri, $cb) {
        $this->route('post', $uri, $cb);
        return $this;
    }

    public function put($uri, $cb) {
        $this->route('put', $uri, $cb);
        return $this;
    }

    public function delete($uri, $cb) {
        $this->route('delete', $uri, $cb);
        return $this;
    }

    public function middleware($class) {
        $this->routes[ $this->routeIndex ]['action']['middleware'][] = $class;
        return $this;
    }

    public function dispatch(Request $request) {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->routeIndex = $method . $uri;

        $route = $this->getCurrRoute();
        if (!$route) return 404;

        $middleware = $route['action']['middleware'];
        $callback = $route['action']['cb'];

        if (!$callback instanceof \Closure) {
            $action = $route['action'];
            $cb = explode('@', $action['cb']);
            $controller = $action['namespace'] . '\\' . $cb[0]; // 控制器
            $method = $cb[1]; // 方法
            /** @var Controller $controllerInstance */
            $controllerInstance = new $controller();
            $middleware = array_merge($middleware, $controllerInstance->getMiddleware()); // 合并控制器中间件
            $callback = function ($request) use ($controllerInstance, $method) {
                return $controllerInstance->callAction($method, [$request]);
            };
        }

        return (new PipeLine())->send($request)->through($middleware)->then($callback);
    }


    private function addSlash(&$uri) {
        if ('/' != $uri[0]) $uri = '/' . $uri;
    }

    private function getCurrRoute() {
        $routes = $this->routes;
        $routeIndex = $this->routeIndex;

        if (isset($routes[ $routeIndex ])) return $routes[ $routeIndex ];
        $routeIndex .= '/';
        if (isset($routes[ $routeIndex ])) return $routes[ $routeIndex ];
        return false;
    }
}
