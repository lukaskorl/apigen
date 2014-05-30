<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class File extends Field {

    protected $allowedAdminDecorators = ['title', 'location', 'naming', 'length', 'size_limit', 'mimes'];

    protected $admin_type = "file";

    protected $db_type = "string";

} 