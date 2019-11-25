<?php


namespace nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Parser\ClassParser;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\Scripts\AppendUseCaseScriptInterface;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\Scripts\UseCaseSettingScript;

class ClarcProviderAppendUseCaseInteractor implements ClarcProviderAppendUseCaseInputPortInterface
{
    /**
     * @var ClarcProviderAppendUseCaseOutputPortInterface
     */
    private $outputPort;

    /**
     * ClarcProviderAppendUseCaseInteractor constructor.
     * @param ClarcProviderAppendUseCaseOutputPortInterface $outputPort
     */
    public function __construct(ClarcProviderAppendUseCaseOutputPortInterface $outputPort)
    {
        $this->outputPort = $outputPort;
    }


    function handle(ClarcProviderAppendUseCaseInputData $inputData)
    {
        $parser = new ClassParser();
        $classMeta = $parser->parse($inputData->clarcProviderCode);

        $classMeta->setupMethods()
            ->updateMethod('registerUseCases', function ($definition) use ($inputData) {
                $body = $definition->getBody();
                $definition->clearBody();

                $scripts = $this->divideScripts($body);

                $comment = '// ' . $inputData->identifer;
                $inputPortBindCode = $this->makeBindCode($inputData->inputPortName, $inputData->interactorName);
                $outputPortBindCode = $this->makeBindCode($inputData->outputPortName, $inputData->presenterName);
                $script = new UseCaseSettingScript($comment, $inputPortBindCode, $outputPortBindCode);
                array_push($scripts, $script);
                usort($scripts, function ($l, $r) {
                    return $l->getKey() < $r->getKey() ? -1 : 1;
                });

                foreach ($scripts as $script) {
                    $lines = $script->getScripts();
                    foreach ($lines as $line)
                    {
                        $definition->addBody($line);
                    }
                }
            });

        $renderer = new ClassRenderer();
        $rendered = $renderer->render($classMeta);

        $outputData = new ClarcProviderAppendUseCaseOutputData($rendered);

        $this->outputPort->output($outputData);
    }

    private function makeBindCode(string $interfaceName, string $implementName)
    {
        return '$this->app->bind( ' . $interfaceName . '::class, ' . $implementName . '::class);';
    }

    /**
     * @param array $lines
     * @return AppendUseCaseScriptInterface[]
     */
    private function divideScripts(array $lines): array
    {
        $results = [];
        $lineCount = count($lines);
        for ($i = 0; $i < $lineCount; $i++)
        {
            $line = $lines[$i];
            if ($this->startsWith($line, '//')) {
                $comment = $line;
                $bindInputPort = $lines[++$i];
                $bindOutputPort = $lines[++$i];
                array_push($results, new UseCaseSettingScript($comment, $bindInputPort, $bindOutputPort));
            } else if ($this->startsWith($line, '$this->app->bind(')) {
                $bindInputPort = $line;
                $bindOutputPort = $lines[++$i];
                array_push($results, new UseCaseSettingScript(null, $bindInputPort, $bindOutputPort));
            } else {
                throw new \Exception();
            }
        }

        return $results;
    }

    private function startsWith(string $target, $word): bool
    {
        return strpos($target, $word) === 0;
    }
}

class UseCaseSetting
{
    public $comment;
    public $bindInputPort;
    public $bindOutputPort;

    /**
     * UseCaseSetting constructor.
     * @param $comment
     * @param $bindInputPort
     * @param $bindOutputPort
     */
    public function __construct($comment, $bindInputPort, $bindOutputPort)
    {
        $this->comment = $comment;
        $this->bindInputPort = $bindInputPort;
        $this->bindOutputPort = $bindOutputPort;
    }
}