<?php

namespace App\Commands;

use App\Services\Planner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Start extends Command
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

        Storage::put("names.json", json_encode($names));

        shuffle($names);

        $planner = new Planner();
        $planner->setName($names);
        $planner->plan($this);
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
