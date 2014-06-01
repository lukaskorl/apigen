<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateRepositoryCommand extends GeneratorCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apigen:repository';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate an easily extensible CRUD repository for a given model';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        // Prepare input
        $translatableName = $this->translator->translate($this->argument('name'));
        $namespace = $this->getNamespace(true, $translatableName->toModelName());
        $path = $this->getPath($namespace);
        $interfaceTarget = "$path/{$translatableName->toRepositoryName()}Repository.php";
        $eloquentTarget = "$path/Eloquent{$translatableName->toRepositoryName()}Repository.php";
        $transformerTarget = "$path/{$translatableName->toModelName()}Transformer.php";

        // Render and create interface for repository
        $this->renderTemplate('repository_interface.txt', $interfaceTarget, [
            'NAMESPACE' => $namespace,
            'CLASSNAME' => "{$translatableName->toRepositoryName()}Repository"
        ]);

        // Render and create transformer for repository
        $this->renderTemplate('repository_transformer.txt', $transformerTarget, [
            'NAMESPACE' => $namespace,
            'CLASSNAME' => "{$translatableName->toModelName()}Transformer"
        ]);

        // Render and create repository
        $this->renderTemplate('repository_eloquent.txt', $eloquentTarget, [
            'NAMESPACE' => $namespace,
            'CLASSNAME' => "Eloquent{$translatableName->toRepositoryName()}Repository",
            'REPOSITORY' => "{$translatableName->toRepositoryName()}Repository",
            'TRANSFORMER' => "{$translatableName->toModelName()}Transformer",
            'MODEL' => $translatableName->toModelName()
        ]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Name of the corresponding model'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
            array('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the generated repository', null),
            array('path', null, InputOption::VALUE_OPTIONAL, 'PSR-0 target path of the generated file', null),
		);
	}

}
