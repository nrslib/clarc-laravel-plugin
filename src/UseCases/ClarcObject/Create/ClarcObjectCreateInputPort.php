<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


interface ClarcObjectCreateInputPort
{
    function handle(ClarcObjectCreateInputData $inputData);
}