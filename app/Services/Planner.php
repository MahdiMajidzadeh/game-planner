<?php

namespace App\Services;

use NumberToWords\NumberToWords;

class Planner
{
    public $names;

    public function shuffler(array $names)
    {
        if (count($names) % 2 == 1) {
            $names = array_reverse($names);
        }

        return array_chunk($names, 2);
    }

    public function plan($class)
    {
        $round = 0;
        while (count($this->names) > 1) {
            $round         += 1;
            $numberToWords = new NumberToWords();

            $class->alert('^ Round:' . $numberToWords->getNumberTransformer('en')->toWords($round) . ' ^');
            $competitors = self::shuffler($this->names);
            $this->names = [];

            foreach ($competitors as $competitor) {
                if (count($competitor) == 1) {
                    $this->names[] = $competitor[0];
                    break;
                }

                do {
                    $choice = $class->choice($competitor[0] . ' vs. ' . $competitor[1], $competitor);
                } while (!in_array($choice, $competitor));

                $this->names[] = $choice;
            }
        }

        $class->info('Winner is: ' . $this->names[0]);
    }

    public function setName($names)
    {
        $this->names = $names;
    }
}