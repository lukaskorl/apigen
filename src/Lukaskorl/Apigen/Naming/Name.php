<?php namespace Lukaskorl\Apigen\Naming;


class Name {

    /**
     * Name to be translated
     * @var string
     */
    private $name;

    /**
     * Translator to use
     * @var Translator
     */
    private $translator;

    /**
     * Create the object and set the name
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

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

    /**
     * Return the corresponding name of the model
     * @return string
     */
    public function toModelName()
    {
        return $this->translator->studly($this->getNormalizedName());
    }

    /**
     * Generate the table name for this resource
     * @return string
     */
    public function toTableName()
    {
        return $this->translator->snake(
            $this->translator->plural(
                $this->getNormalizedName()
            )
        );
    }

    /**
     * Generate the name used in the administration configuration
     * @return string
     */
    public function toAdminName()
    {
        return $this->toTableName();
    }

    /**
     * Return a humanly readable name for the resource
     * @return string
     */
    public function toReadable()
    {
        return ucwords($this->translator->snake($this->getNormalizedName(), ' '));
    }

    /**
     * Get a normalized representation of the name
     * @return string
     */
    private function getNormalizedName()
    {
        return $this->translator->singular($this->name);
    }

} 