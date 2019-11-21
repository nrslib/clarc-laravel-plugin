<?php


namespace nrslib\ClarcLaravelPluginTests\ClarcObjectCreateInteractor;


use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateOutputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateOutputPortInterface;

class TestClarcObjectCreatePresenter implements ClarcObjectCreateOutputPortInterface
{
    /**
     * @var ClarcObjectCreateOutputData
     */
    private $outputData;

    /**
     * @return ClarcObjectCreateOutputData
     */
    public function getOutputData(): ClarcObjectCreateOutputData
    {
        return $this->outputData;
    }

    function output(ClarcObjectCreateOutputData $outputData)
    {
        $this->outputData = $outputData;
    }
}