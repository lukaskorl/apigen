<?php namespace Lukaskorl\Apigen\Artisan;


use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Lukaskorl\Apigen\Naming\Translator;
use Lukaskorl\Apigen\Parsers\FieldsParser;

abstract class GeneratorCommand extends Command
{

    /**
     * @var \Illuminate\Config\Repository
     */
    protected  $config;

    /**
     * @var \Lukaskorl\Apigen\Naming\Translator
     */
    protected $translator;

    /**
     * @var \Lukaskorl\Apigen\Parsers\FieldsParser
     */
    private $parser;

    /**
     * Dependency injection
     * @param Repository $config
     * @param Translator $translator
     * @param \Lukaskorl\Apigen\Parsers\FieldsParser $parser
     */
    public function __construct(Repository $config, Translator $translator, FieldsParser $parser)
    {
        parent::__construct();
        $this->config = $config;
        $this->translator = $translator;
        $this->parser = $parser;
    }

    /**
     * Return the filesystem path generated classes
     * @param $namespace
     * @return string
     */
    protected function getPath($namespace = null)
    {
        // Take path from option or fallback to config
        $path = ($this->option('path') ? : $path = $this->config->get('apigen::generators.default.path')) . $namespace;
        return $this->translator->path($path)->toFilesystemPath();
    }

    /**
     * Return the namespace for generated classes
     * @return mixed|string
     */
    protected function getNamespace($omitLeadingSlash = false)
    {
        // Take namespace from option or fallback to config
        $namespace = $this->option('namespace') ? : $this->config->get('apigen::generators.default.namespace');
        return $this->translator->path($namespace)->toNamespace($omitLeadingSlash);
    }
}