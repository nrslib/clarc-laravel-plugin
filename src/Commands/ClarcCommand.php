<?php


namespace nrslib\ClarcLaravelPlugin\Commands;


use Illuminate\Console\Command;

class ClarcCommand extends Command
{
    public function title(string $text)
    {
        $this->info('Welcome to Clarc');
        $this->separator();
        $this->info($text);
        $this->separator();
    }

    public function need(string $text)
    {
        while (true) {
            $result = $this->ask($text);
            if (!empty($result)) {
                return $result;
            }
        }
    }

    public function separator()
    {
        $this->line('---------------------------------------------------------------');
    }

    public function newline()
    {
        $this->line('');
    }
}