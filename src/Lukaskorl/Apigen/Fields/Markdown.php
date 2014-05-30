<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Markdown extends Field {

    protected $allowedAdminDecorators = ['title', 'limit', 'height'];

    protected $admin_type = "markdown";

    protected $db_type = "text";

} 