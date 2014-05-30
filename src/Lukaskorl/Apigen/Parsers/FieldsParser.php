<?php namespace Lukaskorl\Apigen\Parsers;

/**
 * Class FieldsParser
 * Based on MigrationFieldsParser (c) Jeffrey Way
 * https://github.com/JeffreyWay/Laravel-4-Generators/blob/master/src/Way/Generators/Parsers/MigrationFieldsParser.php
 *
 * @package Lukaskorl\Apigen\Parsers
 */
class FieldsParser {

    /**
     * Parse a string of fields, like
     * name:string, age:integer
     *
     * @param string $fields
     * @return array
     */
    public static function parse($fields)
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

            $parsed[$index] = ['field' => $property, 'type' => $type];

            if (isset($args)) $parsed[$index]['args'] = $args;
            if ($decorators) {
                $parsed[$index]['decorators'] = [];

                foreach ($decorators as $decorator) {
                    $parsed[$index]['decorators'] = array_merge($parsed[$index]['decorators'], DecoratorParser::parse($decorator));
                }
            }
        }

        return $parsed;
    }

} 