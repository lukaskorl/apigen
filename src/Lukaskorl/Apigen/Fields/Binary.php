<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Binary extends Field {

    public static $identifier = 'binary';

    protected $allowedAdminDecorators = ['title', 'limit', 'height'];

    protected $adminType = "textarea";

    protected $schemaType = "binary";

} 