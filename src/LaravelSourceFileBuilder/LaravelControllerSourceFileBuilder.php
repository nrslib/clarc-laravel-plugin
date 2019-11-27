<?php


namespace nrslib\ClarcLaravelPlugin\LaravelSourceFileBuilder;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Definitions\Methods\MethodDefinition;
use nrslib\Cfg\Meta\Words\AccessLevel;
use nrslib\Cfg\Parser\ClassParser;
use nrslib\Clarc\SourceFileBuilder\Controller\ControllerSourceFileBuilderInterface;
use nrslib\Clarc\UseCases\Commons\Ds\SourceFileData;
use nrslib\Clarc\UseCases\UseCase\Create\UseCaseSchema;

class LaravelControllerSourceFileBuilder implements ControllerSourceFileBuilderInterface
{
    /**
     * @var ClassRenderer
     */
    private $renderer;
    /**
     * @var string|null
     */
    private $currentControllerContent;

    /**
     * LaravelControllerSourceFileBuilder constructor.
     * @param ClassRenderer $renderer
     * @param string|null $currentControllerContent
     */
    public function __construct(ClassRenderer $renderer, string $currentControllerContent = null)
    {
        $this->renderer = $renderer;
        $this->currentControllerContent = $currentControllerContent;
    }

    public function build(UseCaseSchema $schema, string $namespace, string $inputPortName, string $inputPortNamespace): SourceFileData
    {
        $name = $schema->categoryName . 'Controller';

        $clazz = $this->prepareMeta($name, $namespace, $inputPortNamespace, $inputPortName);
        $actionName = lcfirst($schema->usecaseName);

        if (!$this->existMethod($clazz->getMethodsSetting()->getMethods(), $actionName)) {
            $clazz->setupClass()
                ->addUse($inputPortNamespace . '\\' . $inputPortName);
            $clazz->getMethodsSetting()
                ->addMethod($actionName, function ($methodDefinition) use ($actionName, $inputPortName) {
                    $methodDefinition
                        ->setAccessLevel(AccessLevel::public())
                        ->addArgument('inputPort', $inputPortName)
                        ->addBody('// TODO: Implement ' . $actionName . '() method.');
                });
        }

        $contents = $this->renderer->render($clazz);

        return new SourceFileData($name, $contents);
    }

    private function prepareMeta(string $name, string $namespace, string $inputPortNamespace, string $inputPortName)
    {
        if (is_null($this->currentControllerContent)) {
            $clazz = new ClassMeta($name, $namespace);
            $clazz->setupClass()
                ->addUse('Illuminate\Routing\Controller as BaseController')
                ->setExtend('BaseController');
            return $clazz;
        } else {
            $parser = new ClassParser();
            $meta = $parser->parse($this->currentControllerContent);
            return $meta;
        }
    }

    /**
     * @param MethodDefinition[] $methods
     * @param string $name
     * @return bool
     */
    private function existMethod(array $methods, string $name): bool
    {
        foreach ($methods as $method) {
            if ($method->getName() === $name) {
                return true;
            }
        }
        return false;
    }
}