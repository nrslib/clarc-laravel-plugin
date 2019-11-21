<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


interface ClarcObjectCreateOutputPortInterface
{
    function output(ClarcObjectCreateOutputData $outputData);
}