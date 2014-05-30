<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Enum extends Field {

    public static $identifier = 'enum';

    protected $allowedAdminDecorators = ['title', 'options'];

    protected $adminType = "enum";

    protected $schemaType = "enum";

} 