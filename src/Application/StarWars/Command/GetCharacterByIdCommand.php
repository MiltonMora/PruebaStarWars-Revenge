<?php

namespace App\Application\StarWars\Command;

class GetCharacterByIdCommand
{

    private int $characterId;

    public function __construct(int $characterId)
    {
        $this->characterId = $characterId;
    }

    public function getCharacterId(): int
    {
        return $this->characterId;
    }


}
