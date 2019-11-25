<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase;


/**
 * Class ClarcProviderAppendUseCaseInputData
 * @package nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase
 */
class ClarcProviderAppendUseCaseInputData
{
    /**
     * @var
     */
    public $clarcProviderCode;
    /**
     * @var
     */
    public $clarcDebugProviderCode;
    /**
     * @var string
     */
    public $identifer;
    /**
     * @var string
     */
    public $inputPortName;
    /**
     * @var string
     */
    public $interactorName;
    /**
     * @var string
     */
    public $outputPortName;
    /**
     * @var string
     */
    public $presenterName;

    /**
     * ClarcProviderAppendUseCaseInputData constructor.
     * @param $clarcProviderCode
     * @param $clarcDebugProviderCode
     * @param string $identifer
     * @param string $inputPortName
     * @param string $interactorName
     * @param string $outputPortName
     * @param string $presenterName
     */
    public function __construct(
        $clarcProviderCode,
        $clarcDebugProviderCode,
        string $identifer,
        string $inputPortName,
        string $interactorName,
        string $outputPortName,
        string $presenterName)
    {
        $this->clarcProviderCode = $clarcProviderCode;
        $this->clarcDebugProviderCode = $clarcDebugProviderCode;
        $this->identifer = $identifer;
        $this->inputPortName = $inputPortName;
        $this->interactorName = $interactorName;
        $this->outputPortName = $outputPortName;
        $this->presenterName = $presenterName;
    }
}