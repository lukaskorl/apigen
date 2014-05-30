<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Char extends Field {

    public static $identifier = 'char';

    protected $allowedAdminDecorators = ['title', 'limit'];

    protected $adminType = "text";

    protected $schemaType = "char";

} 