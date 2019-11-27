<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Clarc\UseCases\Commons\Ds\TypeAndName;

class ClarcObjectCreateInputData
{
    /**
     * @var string
     */
    public $controllerName;

    /**
     * @var string|null
     */
    public $currentControllerContent;

    /**
     * @var string
     */
    public $actionName;

    /**
     * @var TypeAndName[]
     */
    public $inputDataFields;

    /**
     * @var TypeAndName[]
     */
    public $outputDataFields;

    /**
     * ClarcObjectCreateInputData constructor.
     * @param string $controllerName
     * @param string|null $currentControllerContent
     * @param string $actionName
     * @param TypeAndName[] $inputDataFields
     * @param TypeAndName[] $outputDataFields
     */
    public function __construct(string $controllerName, ?string $currentControllerContent, string $actionName, array $inputDataFields, array $outputDataFields)
    {
        $this->controllerName = $controllerName;
        $this->currentControllerContent = $currentControllerContent;
        $this->actionName = $actionName;
        $this->inputDataFields = $inputDataFields;
        $this->outputDataFields = $outputDataFields;
    }
}