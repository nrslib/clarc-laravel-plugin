<?php


namespace nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Clarc\SourceFileBuilder\Controller\ControllerSourceFileBuilderInterface;
use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;

class LaravelControllerSourceFileBuilder implements ControllerSourceFileBuilderInterface
{
    private $renderer;

    public function __construct(ClassRenderer $renderer)
    {
        $this->renderer = $renderer;
    }


    function build(UseCaseSchema $schema, string $namespace, string $inputPortName, string $inputPortNamespace): SourceFileData
    {
        $name = $schema->categoryName . 'Controller';

        $clazz = new ClassMeta($name, $namespace);
        $clazz->setupClass()
            ->addUse('Illuminate\Routing\Controller as BaseController')
            ->addUse($inputPortNamespace . '\\' . $inputPortName)
            ->setExtend('BaseController');

        $actionName = lcfirst($schema->usecaseName);
        $clazz->getMethodsSetting()
            ->addMethod($actionName, function ($methodDefinition) use ($actionName, $inputPortName) {
                $methodDefinition
                    ->addArgument('inputPort', $inputPortName)
                    ->addBody('// TODO: Implement ' . $actionName . '() method.');
            });

        $contents = $this->renderer->render($clazz);

        return new SourceFileData($name, $contents);
    }
}