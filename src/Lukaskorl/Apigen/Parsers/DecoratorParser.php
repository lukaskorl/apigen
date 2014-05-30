<?php namespace Lukaskorl\Apigen\Parsers;

/**
 * Class DecoratorParser
 *
 * @package Lukaskorl\Apigen\Parsers
 */
class DecoratorParser {

    /**
     * Parse a string with parameters like
     * size(20,30)
     *
     * @param string $decorator
     * @return array
     */
    public static function parse($decorator)
    {
        if ( ! $decorator) return [];

        $parsed = [
            'name' => null,
            'args' => []
        ];

        // See if args were provided, like:
        // string(10,20)
        if (preg_match('/(.+?)\(([^)]+)\)/', $decorator, $matches))
        {
            $name = $matches[1];

            // Explode and trim arguments
            $args = array_map(function($value) { return trim($value, ' \'"'); }, explode(',', $matches[2]));

            // Add to result
            $parsed['name'] = $name;
            $parsed['args'] = $args;
        } else {
            $parsed['name'] = $decorator;
        }

        return $parsed;
    }

} 