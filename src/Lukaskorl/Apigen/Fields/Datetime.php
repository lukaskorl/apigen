<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Datetime extends Field {

    public static $identifier = 'datetime';

    protected $allowedAdminDecorators = ['title', 'date_format', 'time_format'];

    protected $adminType = "datetime";

    protected $schemaType = "datetime";

} 