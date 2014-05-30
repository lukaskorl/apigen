<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Color extends Field {

    public static $identifier = 'color';

    protected $adminType = "color";

    protected $schemaType = "char";

} 