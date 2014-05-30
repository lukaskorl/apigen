<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Password extends Field {

    public static $identifier = 'password';

    protected $adminType = "password";

    protected $schemaType = "string";

} 