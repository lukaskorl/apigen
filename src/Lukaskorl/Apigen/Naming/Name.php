<?php namespace Lukaskorl\Apigen\Naming;


class Name extends Translatable {

    /**
     * Return the corresponding name of the model
     * @return string
     */
    public function toModelName()
    {
        return $this->translator->studly($this->getNormalizedName());
    }

    /**
     * Return the plural form of the model name
     * @return string
     */
    public function toRepositoryName()
    {
        return $this->translator->plural($this->toModelName());
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
     * Get the singular form of the table name
     * @return string
     */
    public function toTableSingular()
    {
        return $this->translator->snake(
            $this->translator->singular(
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
    public function toReadableName()
    {
        return ucwords(str_replace('_', ' ', $this->translator->snake($this->getNormalizedName(), ' ')));
    }

    /**
     * Return the readable representation in plural form
     * @return string
     */
    public function toReadablePlural()
    {
        return ucwords($this->translator->snake($this->translator->plural($this->getNormalizedName(), ' ')));
    }


    /**
     * Return a singular form of the name
     * @return string
     */
    public function toSingularForm()
    {
        return $this->translator->camel(
            $this->translator->singular($this->getNormalizedName())
        );
    }

    /**
     * Get a normalized representation of the name
     * @return string
     */
    private function getNormalizedName()
    {
        return $this->translator->singular($this->getNative());
    }

} 