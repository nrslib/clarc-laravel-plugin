<?php


namespace nrslib\ClarcLaravelPluginTests\ClarcProviderAppendUseCaseInteractor;


use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseInputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcProvider\AppendUseCase\ClarcProviderAppendUseCaseInteractor;
use PHPUnit\Framework\TestCase;

class ClarcProviderAppendUseCaseInteractorTest extends TestCase
{
    public function testAppend()
    {
        $projectPath = '..\\StrictLaraClean\\src';

        $providerPath = $projectPath . '\\app\Providers';
        $currentClarcProviderCode = file_get_contents($providerPath . '\\ClarcProvider.php');
        $presenter = new TestClarcProviderAppendUseCaseUseCasePresenter();
        $interactor = new ClarcProviderAppendUseCaseInteractor($presenter);

        $inputData = new ClarcProviderAppendUseCaseInputData(
            $currentClarcProviderCode,
            '',
            'TestMyAction',
            '\\' . LaravelConfig::NAMESPACE_INPUT_PORT . '\\' . 'Test\\TestMyActionInputPortInterface',
            '\\' . LaravelConfig::NAMESPACE_INTERACTOR . '\\' . 'Test\\TestMyActionInteractor',
            '\\' . LaravelConfig::NAMESPACE_OUTPUT_PORT . '\\' . 'Test\\TestMyActionOutputPortInterface',
            '\\' . LaravelConfig::NAMESPACE_PRESENTER . '\\' . 'Test\\TestMyActionPresenter');
        $interactor->handle($inputData);
        $outputdata = $presenter->outputData;

        file_put_contents($providerPath . '\\ClarcProvider.txt', $outputdata->getClarcProviderCode());
    }
}