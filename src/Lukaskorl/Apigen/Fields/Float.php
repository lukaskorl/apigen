<?php namespace Lukaskorl\Apigen\Fields;


use Lukaskorl\Apigen\Field;

class Float extends Field {

    public static $identifier = 'float';

    protected $decorators = [
        'decimals' => 2
    ];

    protected $allowedAdminDecorators = ['title', 'symbol', 'decimals', 'thousands_separator', 'decimal_separator'];

    protected $adminType = "number";

    protected $schemaType = "float";

} 