<?php namespace Lukaskorl\Apigen\Parsers;

use Illuminate\Foundation\Application;
use Lukaskorl\Apigen\Exceptions\FieldTypeNotFound;
use Lukaskorl\Apigen\Field;

/**
 * Class FieldsParser
 * Based on MigrationFieldsParser (c) Jeffrey Way
 * https://github.com/JeffreyWay/Laravel-4-Generators/blob/master/src/Way/Generators/Parsers/MigrationFieldsParser.php
 *
 * @package Lukaskorl\Apigen\Parsers
 */
class FieldsParser {

    protected static $types = [];
    /**
     * @var
     */
    private $app;

    /**
     * Register a new field type
     *
     * @param $className
     * @internal param $type
     */
    public static function registerType($className)
    {
        self::$types[$className::$identifier] = $className;
    }

    /**
     * Dependency injection
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Parse a string of fields, like
     * name:string, age:integer
     *
     * @param string $fields
     * @return array
     */
    public function parse($fields)
    {
        if ( ! $fields) return [];

        // name:string, age:integer
        // name:string(10,2), age:integer
        $fields = preg_split('/\s?,\s/', $fields);

        $parsed = [];

        foreach($fields as $index => $field)
        {
            // Example:
            // name:string:nullable => ['name', 'string', 'nullable']
            // name:string(15):nullable
            $chunks = preg_split('/\s?:\s?/', $field, null);

            // The first item will be our property
            $property = array_shift($chunks);

            // The next will be the schema type
            $type = array_shift($chunks);

            $args = null;

            // See if args were provided, like:
            // name:string(10)
            if (preg_match('/(.+?)\(([^)]+)\)/', $type, $matches))
            {
                $type = $matches[1];

                // Explode and trim arguments
                $args = array_map(function($value) { return trim($value); }, explode(',', $matches[2]));
            }

            // Finally, anything that remains will
            // be our decorators
            $decorators = $chunks;

            $parsed[$index] = ['property' => $property, 'field' => $this->createInstanceOfField($type)];

            if (isset($args)) $parsed[$index]['field']->setArguments($args);
            if ($decorators) {
                foreach ($decorators as $decorator) {
                    extract(DecoratorParser::parse($decorator));
                    $parsed[$index]['field']->addDecorator($name, $args);
                }
            }
        }

        return $parsed;
    }

    /**
     * Instantiate a field object
     *
     * @param $identifier
     * @return mixed
     * @throws \Lukaskorl\Apigen\Exceptions\FieldTypeNotFound
     */
    protected function createInstanceOfField($identifier)
    {
        if ( ! isset(self::$types[$identifier])) {
            throw new FieldTypeNotFound;
        }

        // Instantiate the field and return the instance
        return $this->app->make(self::$types[$identifier]);
    }

} 