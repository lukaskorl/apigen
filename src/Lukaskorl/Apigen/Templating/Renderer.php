<?php namespace Lukaskorl\Apigen\Templating;

class Renderer {

    /**
     * Compile the template using
     * the given data
     *
     * @param $template
     * @param $data
     * @return mixed
     */
    public function compile($template, $data, $escape = true)
    {
        foreach($data as $key => $value)
        {
            $template = preg_replace("/\\#$key\\#/i", $escape?var_export($value, true):$value, $template);
        }

        return $template;
    }

}
