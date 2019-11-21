<?php


namespace nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Words\AccessLevel;
use nrslib\Clarc\SourceFileBuilder\Presenter\PresenterSourceFileBuilderInterface;
use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;

class LaravelPresenterSourceFileBuilder implements PresenterSourceFileBuilderInterface
{
    /**
     * @var ClassRenderer
     */
    private $classRenderer;

    /**
     * LaravelPresenterSourceFileBuilder constructor.
     * @param ClassRenderer $classRenderer
     */
    public function __construct(ClassRenderer $classRenderer)
    {
        $this->classRenderer = $classRenderer;
    }


    function build(UseCaseSchema $schema, string $namespace, string $outputDataName, string $outputPortName, string $outputPortNamespace): SourceFileData
    {
        $name = $schema->fullName() . 'Presenter';

        $clazz = new ClassMeta($name , $namespace);
        $clazz->setupClass()
            ->addUse($outputPortNamespace . '\\' . $outputPortName)
            ->addUse($outputPortNamespace . '\\' . $outputDataName)
            ->addImplement($outputPortName);
        $clazz->setupMethods()
            ->addMethod('output', function ($methodDefine) use ($outputDataName) {
                $methodDefine->addArgument('outputData', $outputDataName)
                    ->setAccessLevel(AccessLevel::public());
            });

        $contents = $this->classRenderer->render($clazz);

        return new SourceFileData($name, $contents);
    }
}