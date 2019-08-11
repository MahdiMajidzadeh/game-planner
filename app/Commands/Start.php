<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Start extends Command
{
    protected $signature = 'start';

    protected $description = 'start game';

    private $names = [];

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

        while (count($this->names) > 1) {
            $this->alert('^Next Round^');
            $competitors = $this->planner($this->names);
            $this->names = [];

            foreach ($competitors as $competitor) {
                if (count($competitor) == 1) {
                    $this->names[] = $competitor[0];
                    break;
                }

                do {
                    $choice = $this->choice($competitor[0] . ' vs. ' . $competitor[1], $competitor);
                } while (!in_array($choice, $competitor));

                $this->names[] = $choice;
//                $this->names[] = $this->choice('winner: ', $competitor);
            }
        }

        $this->info('Winner is: ' . $this->names[0]);
    }

    private function planner($names)
    {
        if (count($names) % 2 == 1) {
            $names = array_reverse($names);
        }

        return array_chunk($names, 2);
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
