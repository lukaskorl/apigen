<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateModelCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apigen:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a model class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        //
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the model to generate'),
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
            array('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the generated model', null),
            array('path', null, InputOption::VALUE_OPTIONAL, 'PSR-0 target path of the generated file', null),
        );
    }

}
