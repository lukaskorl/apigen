<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Markdown extends Field {

    public static $identifier = 'markdown';

    protected $allowedAdminDecorators = ['title', 'limit', 'height'];

    protected $adminType = "markdown";

    protected $schemaType = "text";

} 