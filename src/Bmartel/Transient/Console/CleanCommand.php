<?php
namespace Bmartel\Transient\Console;


use Bmartel\Transient\Exception\InvalidObjectTypeException;
use Bmartel\Transient\TransientPropertyInterface;
use Bmartel\Transient\TransientRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CleanCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'transient:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired transient values.';
    /**
     * @var \Bmartel\Transient\TransientRepositoryInterface
     */
    private $transient;

    /**
     * @var InputParser
     */
    private $inputParser;

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;


    public function __construct(TransientRepositoryInterface $transient, InputParser $inputParser, Application $app)
    {
        $this->transient = $transient;
        $this->inputParser = $inputParser;
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Bmartel\Transient\Exception\InvalidObjectTypeException
     * @return mixed
     */
    public function fire()
    {
        // If user provided a class as an argument,
        // ensure its a valid class which implments \Bmartel\Transient\TransientPropertyInterface.
        if ($class = $this->argument('modelClass')) {

            // Parse the class
            $model = $this->inputParser->parse($class);

            $modelType = $this->app->make($model);

            if (!$modelType instanceof TransientPropertyInterface)
                throw new InvalidObjectTypeException('Class does not implement \Bmartel\Transient\TransientPropertyInterface');
        }

        // If user provided property options, parse them into an array for querying.
        if ($properties = $this->option('properties'))
            $transientProperties = $this->inputParser->parseProperties($properties);

        $result = null;

        // Determine what parameters to base the transient removal on.
        if (isset($transientProperties) && isset($modelType))
            $result = $this->transient->deleteByModelProperty($modelType, $transientProperties);
        elseif (isset($modelType))
            $result = $this->transient->deleteByModelType($modelType);
        elseif (isset($transientProperties))
            $result = $this->transient->deleteByProperty($transientProperties);
        else
            $result = $this->transient->deleteAll();

        $propertiesName = str_plural('property', $result);

        // Report the result of the command
        $this->info("All done! Removed $result transient $propertiesName.");
    }

    protected function getArguments()
    {
        return [
            ['modelClass', InputArgument::OPTIONAL, 'The model class scope to perform the transient clean up on.', null]
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['properties', null, InputOption::VALUE_OPTIONAL, 'A comma-separated list of properties for the command.', null]
        ];
    }
} 