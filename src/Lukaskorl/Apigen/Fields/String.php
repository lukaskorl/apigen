<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class String extends Field {

    protected $allowedAdminDecorators = ['title', 'limit'];

    protected $admin_type = "text";

    protected $db_type = "string";

} 