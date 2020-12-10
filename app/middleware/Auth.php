<?php
namespace app\middleware;

use core\Request;


class Auth {
    public function handle(Request $request, \Closure $next) {
        echo "<hr/>Auth middleware<hr/>";
        return $next($request);
    }
}
