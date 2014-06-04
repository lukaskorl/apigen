<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class File extends Field {

    public static $identifier = 'file';

    protected $allowedAdminDecorators = ['title', 'location', 'naming', 'length', 'size_limit', 'mimes'];

    protected $adminType = "file";

    protected $schemaType = "string";

} 