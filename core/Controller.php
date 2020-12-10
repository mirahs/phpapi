<?php
namespace core;


class Controller {
    /**
     * 中间件列表
     * @var array
     */
    protected $middleware = [];


    /**
     * 获取中间件
     * @return array
     */
    public function getMiddleware() {
        return $this->middleware;
    }

    /**
     * 调用控制器方法
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters) {
        return call_user_func_array([$this, $method], $parameters);
    }
}
