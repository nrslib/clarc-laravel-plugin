<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\InterfaceRenderer;
use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateInputData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateInteractor;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateNamespaceData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateOutputData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;
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
        $inputPortNameSpace = 'packages\\InputPorts\\' . $inputData->controllerName;
        $namespaces = new UseCaseCreateNamespaceData(
            'App\\Http\\Controllers\\' . $inputData->controllerName,
            $inputPortNameSpace,
            'packages\\Interactors\\' . $inputData->controllerName,
            'packages\\OutputPorts\\' . $inputData->controllerName,
            'packages\\Presenters\\' . $inputData->controllerName
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
//
//    /**
//     * @param ClarcObjectCreateInputData $inputData
//     * @param UseCaseCreateNamespaceData $namespaces
//     * @param UseCaseCreateOutputData $usecaseCreateOutputData
//     * @param string $inputPortNameSpace
//     * @return SourceFileData
//     */
//    public function createControllerSourceFile(ClarcObjectCreateInputData $inputData, UseCaseCreateNamespaceData $namespaces, UseCaseCreateOutputData $usecaseCreateOutputData, string $inputPortNameSpace): SourceFileData
//    {
//        $controllerBuilder = new LaravelControllerSourceFileBuilder($this->classRenderer);
//
//        $controllerSourceFile = $controllerBuilder->build(
//            $inputData->controllerName, $inputData->actionName,
//            $namespaces->controllerNamespace,
//            $usecaseCreateOutputData->getInputPortSourceFile()->getClassName(),
//            $inputPortNameSpace);
//
//        return $controllerSourceFile;
//    }
//
//    /**
//     * @param ClarcObjectCreateInputData $inputData
//     * @param UseCaseCreateNamespaceData $namespaces
//     * @param UseCaseCreateOutputData $usecaseCreateOutputData
//     * @param string $inputPortNameSpace
//     * @return SourceFileData
//     */
//    public function createPresenterSourceFile(ClarcObjectCreateInputData $inputData, UseCaseCreateNamespaceData $namespaces, UseCaseCreateOutputData $usecaseCreateOutputData, string $outputPortNameSpace): SourceFileData
//    {
//        $presenterSourceFileBuilder = new LaravelPresenterSourceFileBuilder($this->classRenderer);
//
//        $controllerSourceFile = $presenterSourceFileBuilder->build(
//            $inputData->controllerName, $inputData->actionName,
//            $namespaces->controllerNamespace,
//            $usecaseCreateOutputData->getInputPortSourceFile()->getClassName(),
//            $outputPortNameSpace);
//
//        return $controllerSourceFile;
//    }
}