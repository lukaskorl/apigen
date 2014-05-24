<?php namespace Lukaskorl\Apigen;

use Controller, View;

class LoginController extends Controller {

    public function show()
    {
        return View::make('apigen::login');
    }

    public function login()
    {

    }

} 