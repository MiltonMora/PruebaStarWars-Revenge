<?php

namespace App\Application\StarWars;

use App\Application\StarWars\Command\GetCharacterByIdCommand;
use App\Domain\StarWars\Port\CharacterInterface;
use App\Entity\Characters;

class GetCharacterByIdHandler
{
    private CharacterInterface $character;

    public function __construct(CharacterInterface $character)
    {
        $this->character = $character;
    }

    public function handle(GetCharacterByIdCommand $command): Characters
    {
        return $this->character->findOneById($command->getCharacterId());
    }

}
