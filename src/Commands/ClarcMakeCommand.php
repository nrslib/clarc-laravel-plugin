<?php


namespace nrslib\ClarcLaravelPlugin\Commands;


use Illuminate\Console\Command;

class ClarcMakeCommand extends Command
{
    protected $signature = 'clarc:make';

    public function handle()
    {
        $this->info('testa');
    }
}