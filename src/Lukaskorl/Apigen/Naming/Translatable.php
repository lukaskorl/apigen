<?php namespace Lukaskorl\Apigen\Naming;


abstract class Translatable {

    use TranslationDelegate;

    private $native = null;

    /**
     * Constructor accepting the native sentence
     * @param $native
     */
    public function __construct($native)
    {
        $this->native = $native;
    }

    /**
     * Return the native sentence
     * @return null
     */
    protected function getNative()
    {
        return $this->native;
    }

} 