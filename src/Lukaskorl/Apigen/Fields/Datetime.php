<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Datetime extends Field {

    protected $allowedAdminDecorators = ['title', 'date_format', 'time_format'];

    protected $admin_type = "datetime";

    protected $db_type = "datetime";

} 