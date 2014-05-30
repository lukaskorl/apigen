<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Image extends Field {

    protected $allowedAdminDecorators = ['title', 'location', 'naming', 'length', 'size_limit'];

    protected $admin_type = "image";

    protected $db_type = "string";

} 