<?php

namespace App\Domain\StarWars\Port;

use App\Entity\MoviesCharacters;

interface MoviesCharactersInterface
{
    public function store(MoviesCharacters $moviesCharacters): void;
}
