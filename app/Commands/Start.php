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

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
