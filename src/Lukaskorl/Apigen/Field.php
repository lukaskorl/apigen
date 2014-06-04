<?php namespace Lukaskorl\Apigen;


abstract class Field {

    public static $identifier = null;

    protected $decorators = [];

    protected $arguments = [];

    protected $allowedAdminDecorators = ['title'];

    protected $allowedDatabaseDecorators = ['nullable', 'default', 'unique'];

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
            if ($arguments = $this->getDecorator($name)) {
                // Apply this decorator to the configuration
                $editField[$name] = $arguments;
            }
        }

        return $editField;
    }

    /**
     * Generate schema definition string of the field (This string can be used by Jeffrey Way's Laravel Generator)
     * @return string
     */
    public function toSchemaDefinition()
    {
        // Begin with the field's type
        $definition = $this->schemaType;

        // Append arguments of there are any
        $args = $this->getArguments();
        if (is_array($args) && count($args) > 0) {
            // Preprocess arguments
            foreach ($args as $index => $value) {
                $decoratorArgs[$index] = var_export($value, true);
            }
            $definition .= "(".implode(',', $args).")";
        }

        // Append decorators
        foreach ($this->decorators as $decoratorName => $decoratorArgs) {
            // Only append decorators which are suitable for the schema creation
            if (in_array($decoratorName, $this->allowedDatabaseDecorators)) {
                $definition .= ":".$decoratorName;

                // Append arguments if necessary
                if (is_array($decoratorArgs) && count($decoratorArgs) > 0) {
                    // Preprocess arguments
                    foreach ($decoratorArgs as $index => $value) {
                        $decoratorArgs[$index] = var_export($value, true);
                    }
                    $definition .= "(".implode(',', $decoratorArgs).")";
                }
            }
        }

        return $definition;
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

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

} 