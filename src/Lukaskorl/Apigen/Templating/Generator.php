<?php namespace Lukaskorl\Apigen\Templating;


use Illuminate\Filesystem\Filesystem;

class Generator {

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    public function __construct(Renderer $renderer, Filesystem $filesystem)
    {
        $this->renderer = $renderer;
        $this->filesystem = $filesystem;
    }

    public function compile($templateName, $data, $escape = true)
    {
        $template = $this->filesystem->get($this->getTemplatePath($templateName));

        return $this->renderer->compile($template, $data, $escape);
    }

    /**
     * @param $templateName
     */
    protected function getTemplatePath($templateName)
    {
        return __DIR__ . '/../templates/' . $templateName;
    }

} 