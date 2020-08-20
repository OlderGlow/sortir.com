<?php


namespace App\Service;


class EventManager
{

    public function dateUpdate($char, $i, $time)
    {
        $now = new \DateTime('now');
        if($char == 0 && $i == 0 && $time == 0)
            return $now;


        if($char === '+')
        {
            $now->modify($char.$i.$time);
        }
        return $now;
    }
}