<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;

class Start extends Base
{
    protected $signature = 'start';

    protected $description = 'start game';

    public function handle()
    {
        $names = [];
        while (true) {
            $input = $this->ask('Enter Player name:');
            if ($input == 'exit' || $input == '0') {
                break;
            }
            $names[] = $input;
        }
        shuffle($names);

        $this->names = $names;

        $this->do();

    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
