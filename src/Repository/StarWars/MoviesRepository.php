<?php

namespace App\Repository\StarWars;

use App\Domain\StarWars\Port\MoviesInterface;
use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movies>
 *
 * @method Movies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movies[]    findAll()
 * @method Movies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesRepository extends ServiceEntityRepository implements MoviesInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movies::class);
    }

    public function store(Movies $movie): void
    {
        $this->getEntityManager()->persist($movie);
        $this->getEntityManager()->flush();
    }

    public function getFilmByName(string $name): ?Movies
    {
        return $this->findOneBy(['name' => $name]);
    }
}
