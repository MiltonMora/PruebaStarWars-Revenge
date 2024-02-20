<?php

namespace App\Domain\StarWars\Port;

use App\Entity\Characters;

interface CharacterInterface
{
    public function store(Characters $characters): void;
    public function findAll();
    public function findOneByName(string $name): ?Characters;
    public function findOneById(int $id): Characters;
}
