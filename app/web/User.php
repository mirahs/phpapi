<?php
namespace app\web;

use app\middleware\Auth;
use core\Controller;
use core\Request;


class User extends Controller {
    protected $middleware = [
        Auth::class
    ];


    public function index(Request $request) {
        return [
            'method' => $request->getMethod(),
            'url' =>  $request->getUri()
        ];
    }
}
