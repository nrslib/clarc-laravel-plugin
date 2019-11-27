<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Initialize;


use Illuminate\Console\Command;
use nrslib\ClarcLaravelPlugin\Code\ClarcModuleCodes;
use nrslib\ClarcLaravelPlugin\Commands\ClarcCommand;
use nrslib\ClarcLaravelPlugin\Config\LaravelConfig;

class ClarcInitializeCommand extends ClarcCommand
{
    protected $signature = 'clarc:init';

    public function handle()
    {
        $this->title('Initialize clarc');

        $middlewareFilePath = LaravelConfig::DIR_MIDDLEWARE . 'ClarcMiddleWare.php';
        $this->info('Creating file ' . $middlewareFilePath);
        file_put_contents($middlewareFilePath, ClarcModuleCodes::$middleWare);
        $this->info('Wrote ' . realpath($middlewareFilePath));
        $this->newline();

        $clarcProviderFilePath = LaravelConfig::DIR_PROVIDER . 'ClarcProvider.php';
        $this->info('Creating file' . $clarcProviderFilePath);
        file_put_contents($clarcProviderFilePath, ClarcModuleCodes::$clarcProvider);
        $this->info('Wrote ' . realpath($clarcProviderFilePath));
        $this->newline();

        $this->info('Please append ClarcProvider to app.php');
    }
}