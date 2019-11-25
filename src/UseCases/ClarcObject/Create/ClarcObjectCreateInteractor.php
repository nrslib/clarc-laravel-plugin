<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\InterfaceRenderer;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateInputData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateInteractor;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateNamespaceData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateOutputData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;
use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;
use nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder\LaravelControllerSourceFileBuilder;
use nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder\LaravelPresenterSourceFileBuilder;

class ClarcObjectCreateInteractor implements ClarcObjectCreateInputPort
{
    /**
     * @var ClarcObjectCreateOutputPortInterface
     */
    private $outputPort;

    /**
     * @var ClassRenderer
     */
    private $classRenderer;

    /**
     * @var InterfaceRenderer
     */
    private $interfaceRenderer;

    /**
     * ClarcObjectCreateInteractor constructor.
     * @param ClarcObjectCreateOutputPortInterface $outputPort
     * @param ClassRenderer $classRenderer
     * @param InterfaceRenderer $interfaceRenderer
     */
    public function __construct(ClarcObjectCreateOutputPortInterface $outputPort, ClassRenderer $classRenderer, InterfaceRenderer $interfaceRenderer)
    {
        $this->outputPort = $outputPort;
        $this->classRenderer = $classRenderer;
        $this->interfaceRenderer = $interfaceRenderer;
    }

    public function handle(ClarcObjectCreateInputData $inputData)
    {
        $inputPortNameSpace = LaravelConfig::INPUT_PORT_NAMESPACE . $inputData->controllerName;
        $namespaces = new UseCaseCreateNamespaceData(
            LaravelConfig::CONTROLLER_NAMESPACE . $inputData->controllerName,
            $inputPortNameSpace,
            LaravelConfig::INTERACTOR_NAMESPACE . $inputData->controllerName,
            LaravelConfig::OUTPUT_PORT_NAMESPACE . $inputData->controllerName,
            LaravelConfig::PRESENTER_NAMESPACE . $inputData->controllerName
        );
        $usecaseCreateOutputData = $this->executeClarcCore($inputData, $namespaces);

        $outputData = new ClarcObjectCreateOutputData(
            $usecaseCreateOutputData->getControllerSourceFile(),
            $usecaseCreateOutputData->getInputPortSourceFile(),
            $usecaseCreateOutputData->getInteractorSourceFile(),
            $usecaseCreateOutputData->getInputDataSourceFile(),
            $usecaseCreateOutputData->getOutputPortSourceFile(),
            $usecaseCreateOutputData->getOutputDataSourceFile(),
            $usecaseCreateOutputData->getPresenterSourceFile()
        );
        $this->outputPort->output($outputData);
    }

    /**
     * @param ClarcObjectCreateInputData $inputData
     * @param UseCaseCreateNamespaceData $namespaces
     * @return UseCaseCreateOutputData
     */
    public function executeClarcCore(ClarcObjectCreateInputData $inputData, UseCaseCreateNamespaceData $namespaces): UseCaseCreateOutputData
    {
        $usecaseCreateDataCollector = new ClarcObjectUseCaseCreateOutputCollector();
        $usecaseCreateInteractor = new UseCaseCreateInteractor(
            $usecaseCreateDataCollector,
            $this->classRenderer,
            $this->interfaceRenderer,
            new LaravelControllerSourceFileBuilder($this->classRenderer),
            new LaravelPresenterSourceFileBuilder($this->classRenderer));
        $usecaseInputData = new UseCaseCreateInputData(
            $namespaces,
            new UseCaseSchema($inputData->controllerName, $inputData->actionName),
            $inputData->inputDataFields,
            $inputData->outputDataFields
        );

        $usecaseCreateInteractor->handle($usecaseInputData);

        return $usecaseCreateDataCollector->getRecentOutputData();
    }
}