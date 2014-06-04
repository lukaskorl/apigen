<?php namespace Lukaskorl\Apigen\Naming;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class Translator {

    /**
     * @var \Illuminate\Support\Pluralizer
     */
    private $pluralizer;

    /**
     * @var \Illuminate\Support\Str
     */
    private $string;

    /**
     * Constructor with dependency injection
     * @param Pluralizer $pluralizer
     * @param \Illuminate\Support\Str $string
     */
    public function __construct(Pluralizer $pluralizer, Str $string)
    {
        $this->pluralizer = $pluralizer;
        $this->string = $string;
    }

    /**
     * Factory method to create a Name
     * @param $name
     * @return Name
     */
    public function translate($name)
    {
        return (new Name($name))->setTranslationDelegate($this);
    }

    /**
     * Factory method for translating paths and namespaces
     * @param $sentence
     * @return Path
     */
    public function path($sentence)
    {
        return (new Path($sentence))->setTranslationDelegate($this);
    }

    /**
     * Convert the given sentence to studly case
     * @param $value
     * @return string
     */
    public function studly($value)
    {
        return $this->string->studly($value);
    }

    /**
     * Convert the given sentence into camel case representation
     * @param $value
     * @return string
     */
    public function camel($value)
    {
        return $this->string->camel($value);
    }

    /**
     * Convert the given sentence into snake case representation
     * @param $value
     * @param string $delimiter
     * @return string
     */
    public function snake($value, $delimiter = '_')
    {
        return $this->string->snake($value, $delimiter);
    }

    /**
     * Get the plural of the given word
     * @param $word
     * @param int $count
     * @return string
     */
    public function plural($word, $count = 2)
    {
        return $this->pluralizer->plural($word, $count);
    }

    /**
     * Convert a word to it's singular
     * @param $word
     * @return string
     */
    public function singular($word)
    {
        return $this->pluralizer->singular($word);
    }

} 