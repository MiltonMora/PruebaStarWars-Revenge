<?php

namespace App\Application\StarWars\Command;

class ListCharactersCommand
{

    private ?string $characterName;

    public function __construct(?string $characterName)
    {
        $this->characterName = $characterName;
    }

    public function getCharacterName(): ?string
    {
        return $this->characterName;
    }

}
