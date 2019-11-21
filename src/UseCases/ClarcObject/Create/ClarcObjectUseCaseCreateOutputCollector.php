<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateOutputData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreatePresenterInterface;

class ClarcObjectUseCaseCreateOutputCollector implements UseCaseCreatePresenterInterface
{
    /**
     * @var UseCaseCreateOutputData
     */
    private $recentOutputData;

    /**
     * @return UseCaseCreateOutputData
     */
    public function getRecentOutputData(): UseCaseCreateOutputData
    {
        return $this->recentOutputData;
    }

    function output(UseCaseCreateOutputData $outputData)
    {
        $this->recentOutputData = $outputData;
    }
}