<?php namespace Lukaskorl\Apigen;

use Controller, View, Config, Input, Auth, Validator, Redirect;
use Illuminate\Session\Store;

class LoginController extends Controller {

    public function show()
    {
        return View::make('apigen::login', [
            'title' => Config::get('administrator::administrator.title')
        ]);
    }

    public function login()
    {
        // Run the validator on the input
        $validator = Validator::make(Input::all(), [
            'email'    => 'required|email', // Check format of email address
            'password' => 'required'
        ]);

        // Show login form again if validation fails
        if ($validator->fails()) {
            return Redirect::route('admin_login')
                ->withErrors($validator) // Send back validation results
                ->withInput(Input::except('password')); // Re-populate form except for the password field
        }

        // Login and redirect to dashboard if successful
        if (Auth::attempt(Input::only('email', 'password'))) {
            return Redirect::route('admin_dashboard');
        }

        // Password or username incorrect
        return Redirect::route('admin_login');
    }

} 