<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase;


interface ClarcProviderAppendUseCaseOutputPortInterface
{
    function output(ClarcProviderAppendUseCaseOutputData $outputData);
}