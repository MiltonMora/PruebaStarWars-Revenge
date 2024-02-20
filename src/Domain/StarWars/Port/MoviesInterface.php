<?php

namespace App\Domain\StarWars\Port;

use App\Entity\Movies;

interface MoviesInterface
{
    public function store(Movies $movie): void;

    public function getFilmByName(string $name): ?Movies;
}
