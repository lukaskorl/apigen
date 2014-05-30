<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Time extends Field {

    protected $allowedAdminDecorators = ['title', 'time_format'];

    protected $admin_type = "time";

    protected $db_type = "time";

} 