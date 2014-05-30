<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Time extends Field {

    public static $identifier = 'time';

    protected $allowedAdminDecorators = ['title', 'time_format'];

    protected $adminType = "time";

    protected $schemaType = "time";

} 