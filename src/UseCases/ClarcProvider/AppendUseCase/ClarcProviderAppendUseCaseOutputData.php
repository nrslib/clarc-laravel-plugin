<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase;


class ClarcProviderAppendUseCaseOutputData
{
    /**
     * @var string
     */
    private $clarcProviderCode;

    /**
     * ClarcProviderAppendUseCaseOutputData constructor.
     * @param string $clarcProviderCode
     */
    public function __construct($clarcProviderCode)
    {
        $this->clarcProviderCode = $clarcProviderCode;
    }

    /**
     * @return mixed
     */
    public function getClarcProviderCode()
    {
        return $this->clarcProviderCode;
    }
}