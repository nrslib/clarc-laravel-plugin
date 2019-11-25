<?php


namespace nrslib\ClarcLaravelPluginTests;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\InterfaceRenderer;
use nrslib\Clarc\UseCases\Commons\Ds\TypeAndName;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateInputData;
use nrslib\ClarcLaravelPlugin\UseCases\ClarcObject\Create\ClarcObjectCreateInteractor;
use nrslib\ClarcLaravelPluginTests\ClarcObjectCreateInteractor\TestClarcObjectCreatePresenter;

class ClarcObjectCreateInteractorTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {

    }

    public function testCreating(): void
    {
        $classRenderer = new ClassRenderer();
        $interfaceRenderer = new InterfaceRenderer();

        $presenter = new TestClarcObjectCreatePresenter();
        $interactor = new ClarcObjectCreateInteractor($presenter, $classRenderer, $interfaceRenderer);
        $inputDataFields = [ new TypeAndName('string', 'aaa') ];
        $outputDataFields = [ new TypeAndName('string', 'aaa') ];
        $controllerName = 'Test';
        $actionName = 'MyAction';
        $inputData = new ClarcObjectCreateInputData($controllerName, $actionName, $inputDataFields, $outputDataFields);
        $interactor->handle($inputData);
        $outputData = $presenter->getOutputData();

        $projectPath = '..\\StrictLaraClean\\src';
        $packagePath = $projectPath . '\\packages';

        $directorySuffix = $controllerName . '\\' . $actionName;

        $controllerPath = $projectPath . '\\app\\Http\\Controllers';
        if (!file_exists($controllerPath)) {
            mkdir($controllerPath, "0777", true);
        }
        $inputPortPath = $packagePath . '\\InputPorts\\' . $directorySuffix;
        if (!file_exists($inputPortPath)) {
            mkdir($inputPortPath, "0777", true);
        }
        $interactorPath = $packagePath . '\\Interactors\\' . $directorySuffix;
        if (!file_exists($interactorPath)) {
            mkdir($interactorPath, "0777", true);
        }
        $outputPortPath = $packagePath . '\\OutputPorts\\' . $directorySuffix;
        if (!file_exists($outputPortPath)) {
            mkdir($outputPortPath, "0777", true);
        }
        $presenterPath = $projectPath . '\\app\\Http\\Presenters\\' . $controllerName;
        if (!file_exists($presenterPath)) {
            mkdir($presenterPath, "0777", true);
        }

        $usecaseName = $controllerName . $actionName;

        file_put_contents($controllerPath . '\\' . $controllerName . 'Controller.php', $outputData->getControllerSourceFile()->getContents());
        file_put_contents($inputPortPath . '\\' . $usecaseName . 'InputPortInterface.php', $outputData->getInputPortSourceFile()->getContents());
        file_put_contents($inputPortPath . '\\' . $usecaseName . 'InputData.php', $outputData->getInputDataSourceFile()->getContents());
        file_put_contents($interactorPath . '\\' . $usecaseName . 'Interactor.php', $outputData->getInteractorSourceFile()->getContents());
        file_put_contents($outputPortPath . '\\' . $usecaseName . 'OutputPortInterface.php', $outputData->getOutputPortSourceFile()->getContents());
        file_put_contents($outputPortPath . '\\' . $usecaseName . 'OutputData.php', $outputData->getOutputDataSourceFile()->getContents());
        file_put_contents($presenterPath . '\\' . $usecaseName . 'Presenter.php', $outputData->getPresenterSourceFile()->getContents());

//        echo $outputData->getControllerSourceFile()->getContents();
//        echo $outputData->getInputPortSourceFile()->getContents();
//        echo $outputData->getInteractorSourceFile()->getContents();
//        echo $outputData->getInputDataSourceFile()->getContents();
//        echo $outputData->getOutputPortSourceFile()->getContents();
//        echo $outputData->getOutputDataSourceFile()->getContents();
//        echo $outputData->getPresenterSourceFile()->getContents();
    }
}