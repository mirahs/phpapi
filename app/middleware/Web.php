<?php
namespace app\middleware;

use core\Request;


class Web {
    public function handle(Request $request, \Closure $next) {
        echo "<hr/>Web middleware<hr/>";
        return $next($request);
    }
}
