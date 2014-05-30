<?php namespace Lukaskorl\Apigen;


abstract class Field {

    protected $decorators = [];

    protected $allowedAdminDecorators = ['title'];

    protected $allowedDatabaseDecorators = [];

    /**
     * Add a decorator to this field
     *
     * @param $name
     * @param array $values
     * @return $this
     */
    public function addDecorator($name, array $values)
    {
        $this->decorators[$name] = $values;
        return $this;
    }

} 