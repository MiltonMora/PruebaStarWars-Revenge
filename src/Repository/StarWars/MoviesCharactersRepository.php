<?php

namespace App\Repository\StarWars;

use App\Domain\StarWars\Port\MoviesCharactersInterface;
use App\Entity\MoviesCharacters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoviesCharacters>
 *
 * @method MoviesCharacters|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoviesCharacters|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoviesCharacters[]    findAll()
 * @method MoviesCharacters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesCharactersRepository extends ServiceEntityRepository implements MoviesCharactersInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoviesCharacters::class);
    }

    public function store(MoviesCharacters $moviesCharacters): void
    {
        $this->getEntityManager()->persist($moviesCharacters);
        $this->getEntityManager()->flush();
    }
}
