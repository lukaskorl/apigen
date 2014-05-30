<?php namespace Lukaskorl\Apigen;


abstract class Field {

    public static $identifier = null;

    protected $decorators = [];

    protected $allowedAdminDecorators = ['title'];

    protected $allowedDatabaseDecorators = [];

    protected $adminType = null;

    protected $schemaType = null;

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

    protected function getDecorator($name)
    {
        // Guard if no matching decorator has been applied
        if ( ! isset($this->decorators[$name])) return false;

        // Otherwise check if we need to return an array
        $arguments = $this->decorators[$name];
        if (is_array($arguments)) {
            // If there is only one argument in the array return it as a single argument
            if (count($arguments) == 1) {
                return array_pop($arguments);
            }

            // If there are more arguments return them as an array
            else if (count($arguments) > 1) {
                return $arguments;
            }

        } else {
            // There is only a single argument
            return $arguments;
        }

        // Fallback if no meaningful data
        return false;
    }

    /**
     * Generate the configuration for edit fields in administrator
     * @return array
     */
    public function generateEditFieldsConfiguration()
    {
        $editField = [];

        // Iterate over the allowed decorators and see if there is a decorator applied
        foreach ($this->allowedAdminDecorators as $name) {
            // Check if there is a decorator applied for this name
            if ($arugments = $this->getDecorator($name)) {
                // Apply this decorator to the configuration
                $editField[$name] = $arugments;
            }
        }

        return $editField;
    }

    /**
     * Return type for field in backend administration
     *
     * @return null
     */
    public function getAdminType()
    {
        return $this->adminType;
    }

    /**
     * Return type for the database schema
     *
     * @return null
     */
    public function getSchemaType()
    {
        return $this->schemaType;
    }

} 