<?php

namespace CarregMusic\Services;

use CarregMusic\Repositories\ConcertRepository;

class ConcertService
{
    function __construct(ConcertRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRandomConcerts(int $numberOfConcerts)
    {
        return $this->repository->getRandomConcerts($numberOfConcerts);
    }
}