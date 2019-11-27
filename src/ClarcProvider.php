<?php


namespace nrslib\ClarcLaravelPlugin;


use Illuminate\Support\ServiceProvider;

class ClarcProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('command.Clarc.make', function ($app) {
            return $app['nrslib\ClarcLaravelPlugin\Commands\Make\ClarcMakeCommand'];
        });
        $this->commands('command.Clarc.make');

        $this->app->singleton('command.Clarc.initialize', function ($app) {
            return $app['nrslib\ClarcLaravelPlugin\Commands\Initialize\ClarcInitializeCommand'];
        });
        $this->commands('command.Clarc.initialize');
    }
}