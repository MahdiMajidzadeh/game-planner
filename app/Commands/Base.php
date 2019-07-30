<?php

namespace App\Commands;

use App\Services\Planner;
use LaravelZero\Framework\Commands\Command;

class Base extends Command
{
    protected $names = [];

    protected function do()
    {
        while (count($this->names) > 1) {
            $this->alert('^Next Round^');
            $competitors = Planner::shuffler($this->names);
            $this->names = [];

            foreach ($competitors as $competitor) {
                if (count($competitor) == 1) {
                    $this->names[] = $competitor[0];
                    break;
                }

                do{
                    $choice = $this->ask($competitor[0] . ' vs. ' . $competitor[1]);
                }while(! in_array($choice, $competitor));

                $this->names[] = $choice;
//                $this->names[] = $this->choice('winner: ', $competitor);
            }
        }

        $this->info('Winner is: ' . $this->names[0]);
    }
}
