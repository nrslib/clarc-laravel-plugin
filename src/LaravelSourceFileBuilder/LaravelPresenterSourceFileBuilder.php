<?php


namespace nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Words\AccessLevel;
use nrslib\Clarc\SourceFileBuilder\Presenter\PresenterSourceFileBuilderInterface;
use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;
use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;

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
            ->addUse(LaravelConfig::NAMESPACE_MIDDLEWARE . '\\' . 'ClarcMiddleware')
            ->addUse(LaravelConfig::NAMESPACE_VIEWMODEL . '\\' . $schema->categoryName . '\\' . $schema->usecaseName . '\\' . $schema->fullName() . 'ViewModel')
            ->addImplement($outputPortName)
            ->setConstructor(function ($definition) {
                $definition->addArgument('middleware', 'ClarcMiddleware')
                    ->addBody('$this->middleware = $middleware;');
            });

        $clazz->setupFields()
            ->addField('middleware', 'ClarcMiddleware');

        $clazz->setupMethods()
            ->addMethod('output', function ($methodDefine) use ($outputDataName, $schema) {
                $methodDefine->addArgument('outputData', $outputDataName)
                    ->setAccessLevel(AccessLevel::public())
                    ->addBody('$viewModel = new ' . $schema->fullName() . 'ViewModel($outputData);')
                    ->addBody('$this->middleware->setData(view(\'view_resource\', compact(\'viewModel\')));');
            });

        $contents = $this->classRenderer->render($clazz);

        return new SourceFileData($name, $contents);
    }
}