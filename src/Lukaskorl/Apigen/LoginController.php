<?php namespace Lukaskorl\Apigen;

use Controller, View, Config;

class LoginController extends Controller {

    public function show()
    {
        return View::make('apigen::login', [
            'title' => Config::get('administrator::administrator.title')
        ]);
    }

    public function login()
    {

    }

} 