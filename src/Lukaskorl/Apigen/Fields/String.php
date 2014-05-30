<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class String extends Field {

    public static $identifier = 'string';

    protected $allowedAdminDecorators = ['title', 'limit'];

    protected $adminType = "text";

    protected $schemaType = "string";

} 