<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase;


interface ClarcProviderAppendUseCaseInputPortInterface
{
    function handle(ClarcProviderAppendUseCaseInputData $inputData);
}