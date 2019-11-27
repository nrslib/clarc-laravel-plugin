<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;

class ClarcObjectCreateOutputData
{
    /**
     * @var SourceFileData
     */
    private $controllerSourceFile;

    /**
     * @var SourceFileData
     */
    private $inputPortSourceFile;

    /**
     * @var SourceFileData
     */
    private $interactorSourceFile;

    /**
     * @var SourceFileData
     */
    private $inputDataSourceFile;

    /**
     * @var SourceFileData
     */
    private $outputPortSourceFile;

    /**
     * @var SourceFileData
     */
    private $outputDataSourceFile;

    /**
     * @var SourceFileData
     */
    private $presenterSourceFile;

    /**
     * @var SourceFileData
     */
    private $viewModelSourceFile;

    /**
     * UseCaseCreateOutputData constructor.
     * @param SourceFileData $controllerSourceFile
     * @param SourceFileData $inputPortSourceFile
     * @param SourceFileData $interactorDataSourceFile
     * @param SourceFileData $inputDataSourceFile
     * @param SourceFileData $outputPortSourceFile
     * @param SourceFileData $outputDataSourceFile
     * @param SourceFileData $presenterSourceFile
     */
    public function __construct(SourceFileData $controllerSourceFile, SourceFileData $inputPortSourceFile, SourceFileData $interactorDataSourceFile, SourceFileData $inputDataSourceFile, SourceFileData $outputPortSourceFile, SourceFileData $outputDataSourceFile, SourceFileData $presenterSourceFile, SourceFileData $viewModelSourceFile) {
        $this->controllerSourceFile = $controllerSourceFile;
        $this->inputPortSourceFile = $inputPortSourceFile;
        $this->interactorSourceFile = $interactorDataSourceFile;
        $this->inputDataSourceFile = $inputDataSourceFile;
        $this->outputPortSourceFile = $outputPortSourceFile;
        $this->outputDataSourceFile = $outputDataSourceFile;
        $this->presenterSourceFile = $presenterSourceFile;
        $this->viewModelSourceFile = $viewModelSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getControllerSourceFile(): SourceFileData
    {
        return $this->controllerSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getInputPortSourceFile(): SourceFileData
    {
        return $this->inputPortSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getInteractorSourceFile(): SourceFileData
    {
        return $this->interactorSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getInputDataSourceFile(): SourceFileData
    {
        return $this->inputDataSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getOutputPortSourceFile(): SourceFileData
    {
        return $this->outputPortSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getOutputDataSourceFile(): SourceFileData
    {
        return $this->outputDataSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getPresenterSourceFile(): SourceFileData
    {
        return $this->presenterSourceFile;
    }

    /**
     * @return SourceFileData
     */
    public function getViewModelSourceFile(): SourceFileData
    {
        return $this->viewModelSourceFile;
    }
}