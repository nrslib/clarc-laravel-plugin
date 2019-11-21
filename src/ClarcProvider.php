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
            return $app['nrslib\ClarcLaravelPlugin\Commands\ClarcMakeCommand'];
        });
        $this->commands('command.Clarc.make');
    }
}