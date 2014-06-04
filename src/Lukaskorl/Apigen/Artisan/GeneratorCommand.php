<?php namespace Lukaskorl\Apigen\Artisan;


use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Lukaskorl\Apigen\Naming\Translator;
use Lukaskorl\Apigen\Parsers\FieldsParser;
use Lukaskorl\Apigen\Templating\Generator;

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
    protected $parser;

    /**
     * @var \Lukaskorl\Apigen\Templating\Generator
     */
    protected $generator;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Dependency injection
     * @param \Lukaskorl\Apigen\Templating\Generator $generator
     * @param Repository $config
     * @param Translator $translator
     * @param \Lukaskorl\Apigen\Parsers\FieldsParser $parser
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Generator $generator, Repository $config, Translator $translator, FieldsParser $parser, Filesystem $filesystem)
    {
        parent::__construct();
        $this->config = $config;
        $this->translator = $translator;
        $this->parser = $parser;
        $this->generator = $generator;
        $this->filesystem = $filesystem;
    }

    /**
     * Return the filesystem path generated classes
     * @param $namespace
     * @return string
     */
    protected function getPath($namespace = null)
    {
        // Take path from option or fallback to config
        $path = ($this->option('path') ? : $this->config->get('apigen::generators.default.path')) . ($namespace?'/'.$namespace:'');
        return $this->translator->path($path)->toFilesystemPath();
    }

    /**
     * Return the namespace for generated classes
     * @param bool $omitLeadingSlash
     * @param bool $appendNamespace
     * @return mixed|string
     */
    protected function getNamespace($omitLeadingSlash = false, $appendNamespace = false)
    {
        // Take namespace from option or fallback to config
        $namespace = $this->option('namespace') ? : $this->config->get('apigen::generators.default.namespace');

        // Append a postfix to the namespace
        if ($appendNamespace) $namespace .= ('\\'.trim($appendNamespace, '\\'));

        return $this->translator->path($namespace)->toNamespace($omitLeadingSlash);
    }

    /**
     * @param $template
     * @param $path
     * @param $data
     * @return int
     */
    protected function renderTemplate($template, $path, $data)
    {
        // Filter input
        $className = str_replace('.php', '', pathinfo($path, PATHINFO_FILENAME));
        // Check if the target file exists
        if ($this->filesystem->exists($path)) {
            $this->error("'$className' already exists.");
            return;
        }

        // Create the underlaying directory
        $this->filesystem->makeDirectory(pathinfo($path, PATHINFO_DIRNAME), 0777, true, true);

        // Compile the template
        $this->info("Creating '$className' ...");
        $template = $this->generator->compile($template, $data, false);
        return $this->filesystem->put($path, $template);
    }
}