<?php

namespace App\Services;

class Planner
{
    static public function shuffler(array $names)
    {
        if (count($names) % 2 == 1) {
            $names = array_reverse($names);
        }

        return array_chunk($names, 2);
    }
}