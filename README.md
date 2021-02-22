# phpapi
a simple restful api framework by php

## 安装依赖
```shell
composer install
```

## 配置
创建 runtime 目录并更改文件用户或组为 apache 或者 nginx 运行用户

## 路由处理
```
routes
    ['group' => GroupPattern, |... ]
    GroupPattern
        ['group' => GroupPattern, |... ] | ['method' => MethodPattern, |...]
        MethodPattern
            ['pattern' => RoutePattern, 'action' => ['cb' => callback, 'middleware' => [], 'namespace' => []]]
```
