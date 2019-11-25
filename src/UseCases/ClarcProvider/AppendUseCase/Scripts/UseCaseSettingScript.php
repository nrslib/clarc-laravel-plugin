<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\Scripts;


class UseCaseSettingScript implements AppendUseCaseScriptInterface
{
    private $commentLine;
    private $bindInputPortLine;
    private $bindOutputPortLine;

    /**
     * UseCaseSettingScript constructor.
     * @param $commentLine
     * @param $bindInputPortLine
     * @param $bindOutputPortLine
     */
    public function __construct($commentLine, $bindInputPortLine, $bindOutputPortLine)
    {
        $this->commentLine = $commentLine;
        $this->bindInputPortLine = $bindInputPortLine;
        $this->bindOutputPortLine = $bindOutputPortLine;
    }

    /**
     * @return string
     */
    function getKey(): string
    {
        if (is_null($this->commentLine)) {
            return '';
        }

        return $this->commentLine;
    }

    /**
     * @return string[]
     */
    function getScripts(): array
    {
        if (is_null($this->commentLine)) {
            return [$this->bindInputPortLine, $this->bindOutputPortLine];
        }

        return [$this->commentLine, $this->bindInputPortLine, $this->bindOutputPortLine];
    }
}