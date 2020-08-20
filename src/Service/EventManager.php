<?php


namespace App\Service;


use App\Repository\SortieRepository;

class EventManager
{

    /**
     * @var SortieRepository
     */
    private $sortieRepository;

    public function __construct(SortieRepository $sortieRepository)
    {
        $this->sortieRepository = $sortieRepository;
    }

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

    public function autoDelete()
    {
        $sorties[] = $this->sortieRepository->findAll();

        for ($i = 0; $i < count($sorties); $i++)
        {

        }
        return $sorties;
    }
}