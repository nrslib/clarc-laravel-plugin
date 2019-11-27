<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Make;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\InterfaceRenderer;
use nrslib\Clarc\UseCases\Commons\Ds\TypeAndName;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;
use nrslib\ClarcLaravelPlugin\Commands\ClarcCommand;
use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateInputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateInteractor;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseInputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseInteractor;

/**
 * Class ClarcMakeCommand
 * @package nrslib\ClarcLaravelPlugin\Commands\Make
 */
class ClarcMakeCommand extends ClarcCommand
{
    /**
     * @var string
     */
    protected $signature = 'clarc:make';

    /**
     *
     */
    public function handle()
    {
        $this->title('Make usecase');

        $this->info('Please input your controller name.');
        $controllerName = $this->need('controller name');
        $controllerName = ucfirst($controllerName);

        $this->info('Please input your action name.');
        $actionName = $this->need('action name.');
        $actionName = ucfirst($actionName);

        $schema = new UseCaseSchema($controllerName, $actionName);
        $objectCreatePresenter = new ClarcMakeCommandObjectCreatePresenter($this, $schema);
        $alreadyRegistered = !$this->checkFiles($controllerName, $actionName, $objectCreatePresenter);
        if ($alreadyRegistered) {
            $this->info('process ended.');
            return;
        }

        $this->info('Please select input data fields');
        $inputDataFields = $this->askFields();
        $this->info('Please select output data fields');
        $outputDataFields = $this->askFields();

        $this->createClarcObjects($objectCreatePresenter, $controllerName, $actionName, $inputDataFields, $outputDataFields);
        $this->registerDependency($controllerName, $actionName);

        $this->info('process ended.');
    }

    /**
     * @param ClarcMakeCommandObjectCreatePresenter $objectCreatePresenter
     * @param string $controllerName
     * @param string $actionName
     * @param TypeAndName[] $inputDataFields
     * @param TypeAndName[] $outputDataFields
     */
    private function createClarcObjects(ClarcMakeCommandObjectCreatePresenter $objectCreatePresenter, string $controllerName, string $actionName, array $inputDataFields, array $outputDataFields)
    {
        $objectCreateInteractor = new ClarcObjectCreateInteractor(
            $objectCreatePresenter,
            new ClassRenderer(),
            new InterfaceRenderer()
        );
        $currentControllerContent = $this->getCurrentControllerContent($controllerName);
        $objectCreateInputData = new ClarcObjectCreateInputData(
            $controllerName,
            $currentControllerContent,
            $actionName,
            $inputDataFields,
            $outputDataFields
        );
        $objectCreateInteractor->handle($objectCreateInputData);
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     */
    private function registerDependency(string $controllerName, string $actionName)
    {
        $presenter = new ClarcMakeCommandProviderAppendUseCasePresenter();

        $currentProviderCode = file_get_contents(LaravelConfig::FILE_CLARC_PROVIDER);

        $identifer = $controllerName . $actionName;
        $inputData = new ClarcProviderAppendUseCaseInputData(
            $currentProviderCode,
            '',
            $identifer,
            $this->createUsingTarget(LaravelConfig::NAMESPACE_INPUT_PORT, $controllerName, $actionName, 'InputPortInterface', true),
            $this->createUsingTarget(LaravelConfig::NAMESPACE_INTERACTOR, $controllerName, $actionName, 'Interactor'),
            $this->createUsingTarget(LaravelConfig::NAMESPACE_OUTPUT_PORT, $controllerName, $actionName, 'OutputPortInterface', true),
            $this->createUsingTarget(LaravelConfig::NAMESPACE_PRESENTER, $controllerName, $actionName, 'Presenter')
        );
        $interactor = new ClarcProviderAppendUseCaseInteractor($presenter);
        $interactor->handle($inputData);
    }

    /**
     * @param string $packagePrefix
     * @param string $controllerName
     * @param string $actionName
     * @param string $suffix
     * @param bool $appendActionNameToNameSpace
     * @return string
     */
    private function createUsingTarget(string $packagePrefix, string $controllerName, string $actionName, string $suffix, bool $appendActionNameToNameSpace = false)
    {
        $prefix = '\\' . $packagePrefix . '\\' . $controllerName;
        if ($appendActionNameToNameSpace) {
            return $prefix . '\\' . $actionName . '\\' . $controllerName . $actionName . $suffix;
        } else {
            return $prefix . '\\' . $controllerName . $actionName . $suffix;
        }
    }

    /**
     * @return array
     */
    private function askFields(): array
    {
        $results = [];

        while (true) {
            $this->separator();
            $choice = $this->choice('Please select field type', ['int', 'string', 'array', 'user defined', 'finish'], 'finish');

            if ($choice === 'finish') {
                goto finish;
            }

            $this->info('Please input field information');

            $name = $this->need('name');
            if (key_exists($name, $results)) {
                $this->error('"' . $name . '" is already registered.');
                $this->separator();
                $this->info('current fields');
                $this->separator();
                $this->showFields($results);
                continue;
            }

            $namespace = null;
            $type = $choice;
            if ($choice === 'user defined') {
                $namespace = $this->need('namespace');
                $type = $this->need('type');
            }
            $fieldInfo = new TypeAndName(
                $type,
                $name,
                $namespace
            );

            $results[$fieldInfo->name] = $fieldInfo;
        }

        finish:
        return $results;
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     * @param ClarcMakeCommandObjectCreatePresenter $presenter
     * @return bool
     */
    private function checkFiles(string $controllerName, string $actionName, ClarcMakeCommandObjectCreatePresenter $presenter): bool
    {
        $overwrites = $presenter->willBeOverwriteFiles($controllerName, $actionName);
        if (empty($overwrites)) {
            return true;
        }

        $this->info('The following file will be overwritten.');
        $this->separator();
        foreach ($overwrites as $file) {
            $fullPath = realpath($file);
            $this->info($fullPath);
        }

        return $this->confirm('ok?', false);
    }

    /**
     * @param TypeAndName[] $fields
     */
    private function showFields(array $fields)
    {
        $firstLine = true;
        foreach ($fields as $field) {
            if (!$firstLine) {
                $this->newline();
            }
            $this->info('name: ' . $field->name);
            $this->info('type: ' . $field->type);
            if ($field->hasNamespace()) {
                $this->info('namespace: ' . $field->namespace);
            }
            $firstLine = false;
        }
    }

    /**
     * @param string $controllerName
     * @return string|null
     */
    private function getCurrentControllerContent(string $controllerName): ?string
    {
        $controllerFile = LaravelConfig::DIR_CONTROLLER . $controllerName . 'Controller.php';
        if (!file_exists($controllerFile)) {
            return null;
        }

        $content = file_get_contents($controllerFile);
        if (empty($content)) {
            return null;
        }

        return $content;
    }
}
