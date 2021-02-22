<?php
namespace core;


final class Helper  {
    /**
     * 确保目录存在
     * @param string $path
     * @return void
     */
    public static function pathSure($path) {
        if (!file_exists($path)) mkdir($path,0777,true);
    }

    /**
     * 获得全部 HTTP 响应头信息
     * @return array|false
     */
    public static function getallheaders() {
        if (!function_exists('getallheaders')) {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }
        return getallheaders();
    }
}
