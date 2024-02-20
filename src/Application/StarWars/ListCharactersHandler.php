<?php

namespace App\Application\StarWars;

use App\Application\StarWars\Command\ListCharactersCommand;
use App\Domain\StarWars\Port\CharacterInterface;

class ListCharactersHandler
{
    private CharacterInterface $character;

    public function __construct(CharacterInterface $character)
    {
        $this->character = $character;
    }

    public function handle(ListCharactersCommand $command): array
    {
        if ($command->getCharacterName()) {
            $character = $this->character->findOneByName($command->getCharacterName());
            if ($character) {
                return [$character];
            }
            return [];
        }
        return $this->character->findAll();
    }

}
