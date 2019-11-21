<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create;


use nrslib\Clarc\UseCases\Commons\Ds\TypeAndName;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseCreateNamespaceData;

class ClarcObjectCreateInputData
{
    /**
     * @var string
     */
    public $controllerName;

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
     * @param string $actionName
     * @param TypeAndName[] $inputDataFields
     * @param TypeAndName[] $outputDataFields
     */
    public function __construct(string $controllerName, string $actionName, array $inputDataFields, array $outputDataFields)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->inputDataFields = $inputDataFields;
        $this->outputDataFields = $outputDataFields;
    }

}