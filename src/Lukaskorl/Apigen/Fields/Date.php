<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Date extends Field {

    public static $identifier = 'date';

    protected $allowedAdminDecorators = ['title', 'date_format'];

    protected $adminType = "date";

    protected $schemaType = "date";

} 