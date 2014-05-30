<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Textarea extends Field {

    public static $identifier = 'textarea';

    protected $allowedAdminDecorators = ['title', 'limit', 'height'];

    protected $adminType = "textarea";

    protected $schemaType = "text";

} 