<?php namespace Lukaskorl\Apigen\Naming;


trait TranslationDelegate {

    /**
     * Translator to use
     * @var Translator
     */
    protected $translator;

    /**
     * Set the translator to use
     * @param Translator $translator
     * @return $this
     */
    public function setTranslationDelegate(Translator $translator)
    {
        $this->translator = $translator;
        return $this;
    }

} 