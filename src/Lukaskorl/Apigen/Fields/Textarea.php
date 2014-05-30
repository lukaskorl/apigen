<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Textarea extends Field {

    protected $allowedAdminDecorators = ['title', 'limit', 'height'];

    protected $admin_type = "textarea";

    protected $db_type = "text";

} 