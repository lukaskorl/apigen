<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Float extends Field {

    protected $allowedAdminDecorators = ['title', 'symbol', 'decimal', 'thousands_separator', 'decimal_separator'];

    protected $admin_type = "number";

    protected $db_type = "float";

} 