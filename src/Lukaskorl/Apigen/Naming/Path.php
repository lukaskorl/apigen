<?php namespace Lukaskorl\Apigen\Naming;


class Path extends Translatable {

    /**
     * Translate to a namespace
     * @param bool $omitLeadingSlash
     * @return string
     */
    public function toNamespace($omitLeadingSlash = false)
    {
        // Make sure each chunk is studly
        $translator = $this->translator;
        $chunks = array_map(function($name) use ($translator) {
            return $translator->studly($name);
        }, $this->getNormalizedArray());

        // Join all chunks together
        return ($omitLeadingSlash?'':"\\").trim(implode("\\", $chunks), "\\");
    }

    /**
     * Translate to a filesystem path
     * @param bool $relativePath
     * @return string
     */
    public function toFilesystemPath($relativePath = true)
    {
        return ($relativePath?'':'/').implode('/', $this->getNormalizedArray());
    }

    /**
     * Return object notation path
     * @return string
     */
    public function toObjectNotation()
    {
        return implode('.', $this->getNormalizedArray());
    }

    /**
     * Try to make sense out of the input and return path as an array
     * @return array
     */
    protected function getNormalizedArray()
    {
        return preg_split("/[\.\/\\\\]+/", $this->getNative());
    }

} 