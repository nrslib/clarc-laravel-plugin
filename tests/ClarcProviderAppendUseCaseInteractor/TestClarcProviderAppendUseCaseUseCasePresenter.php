<?php


namespace nrslib\ClarcLaravelPluginTests\ClarcProviderAppendUseCaseInteractor;


use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseOutputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseOutputPortInterface;

class TestClarcProviderAppendUseCaseUseCasePresenter implements ClarcProviderAppendUseCaseOutputPortInterface
{
    /**
     * @var ClarcProviderAppendUseCaseOutputData
     */
    public $outputData;

    function output(ClarcProviderAppendUseCaseOutputData $outputData)
    {
        $this->outputData = $outputData;
    }
}