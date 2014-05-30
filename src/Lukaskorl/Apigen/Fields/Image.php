<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Image extends Field {

    public static $identifier = 'image';

    protected $allowedAdminDecorators = ['title', 'location', 'naming', 'length', 'size_limit'];

    protected $adminType = "image";

    protected $schemaType = "string";

} 