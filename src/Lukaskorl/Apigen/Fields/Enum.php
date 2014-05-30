<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Enum extends Field {

    protected $allowedAdminDecorators = ['title', 'options'];

    protected $admin_type = "enum";

    protected $db_type = "enum";

} 