<?php

namespace App\Command\StarWars;

use App\Domain\StarWars\Port\CharacterInterface;
use App\Domain\StarWars\Port\MoviesCharactersInterface;
use App\Domain\StarWars\Port\MoviesInterface;
use App\Entity\Characters;
use App\Entity\Movies;
use App\Entity\MoviesCharacters;
use App\Service\StarWars\StarWarsInfoClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'starwars:import',
    description: 'Obtiene datos de la api de star wars y los guarda en la BD',
)]
class StarWarsGenerateCommand extends Command
{
    private StarWarsInfoClient $starWarsInfoClient;
    private CharacterInterface $characterInterface;

    private MoviesInterface $moviesInterface;

    private MoviesCharactersInterface $moviesCharactersInterface;

    private $searchedMovies = [];

    public function __construct(
        StarWarsInfoClient $starWarsInfoClient,
        CharacterInterface $characterInterface,
        MoviesInterface $moviesInterface,
        MoviesCharactersInterface $moviesCharactersInterface
    ) {
        $this->starWarsInfoClient = $starWarsInfoClient;
        $this->characterInterface = $characterInterface;
        $this->moviesInterface = $moviesInterface;
        $this->moviesCharactersInterface = $moviesCharactersInterface;
        parent::__construct();
    }

    protected function configure(): void
    {
        /*$this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;*/
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $peopleData = [];
        for ($i = 1; $i<= 3; $i++){
            $peopleData = array_merge($peopleData, $this->starWarsInfoClient->getPeopleInfo($i)['results']);
        }

        foreach ($peopleData as $people) {
            $character = new Characters();
            $character->setName($people['name']);
            $character->setHeight(floatval($people['height']));
            $character->setMass(floatval($people['mass']));
            $character->setGender($people['gender']);
            $this->characterInterface->store($character);
            $this->getMoviesInfo($people['films'], $character->getId());
        }


        $io->success('Final.');

        return Command::SUCCESS;
    }

    private function getMoviesInfo(array $moviesByCharacter, int $characterId): void
    {
        foreach ($moviesByCharacter as $movie) {
            $movieData = $this->starWarsInfoClient->getFilmsInfoByUrl($movie);
            if (!in_array($movie, $this->searchedMovies)) {
                $film = new Movies();
                $film->setName($movieData['title']);
                $this->moviesInterface->store($film);
                $this->searchedMovies[] = $movie;
                $movieId = $film->getId();
            } else {
                $savedFilm = $this->moviesInterface->getFilmByName($movieData['title']);
                $movieId = $savedFilm->getId();
            }
            $movieCharacter = new MoviesCharacters();
            $movieCharacter->setMovieId($movieId);
            $movieCharacter->setCharacterId($characterId);
            $this->moviesCharactersInterface->store($movieCharacter);
        }
    }
}
