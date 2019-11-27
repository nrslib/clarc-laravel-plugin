<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Make;


use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseOutputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseOutputPortInterface;

class ClarcMakeCommandProviderAppendUseCasePresenter implements ClarcProviderAppendUseCaseOutputPortInterface
{

    function output(ClarcProviderAppendUseCaseOutputData $outputData)
    {
        file_put_contents(LaravelConfig::FILE_CLARC_PROVIDER, $outputData->getClarcProviderCode());
    }
}