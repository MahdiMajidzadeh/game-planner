<?php

namespace App\Commands;

use App\Services\Planner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Restart extends Command
{
    protected $signature = 'restart';

    protected $description = 'restart game';

    public function handle()
    {
        if(!Storage::exists('names.json')){
            $this->error('no names saved!');
            return;
        }
        $names = json_decode(Storage::get('names.json'), true);

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
