<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Wysiwyg extends Field {

    public static $identifier = 'wysiwyg';

    protected $adminType = "wysiwyg";

    protected $schemaType = "text";

}