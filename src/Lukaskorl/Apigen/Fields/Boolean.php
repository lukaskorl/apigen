<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Boolean extends Field {

    public static $identifier = 'boolean';

    protected $adminType = "bool";

    protected $schemaType = "boolean";

} 