<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Date extends Field {

    protected $allowedAdminDecorators = ['title', 'date_format'];

    protected $admin_type = "date";

    protected $db_type = "date";

} 