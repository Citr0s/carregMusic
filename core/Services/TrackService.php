<?php

namespace CarregMusic\Services;

use CarregMusic\Repositories\TrackRepository;

class TrackService
{
    function __construct(TrackRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllBasedOnGenreFor($genre)
    {
        return $this->repository->getAllBasedOnGenreFor($genre);
    }
}