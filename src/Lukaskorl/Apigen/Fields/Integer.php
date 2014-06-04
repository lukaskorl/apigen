<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Integer extends Field {

    public static $identifier = 'integer';

    protected $allowedAdminDecorators = ['title', 'symbol'];

    protected $adminType = "number";

    protected $schemaType = "integer";

} 