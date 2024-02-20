<?php

namespace App\Repository\StarWars;

use App\Domain\StarWars\Port\CharacterInterface;
use App\Entity\Characters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Characters>
 *
 * @method Characters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characters[]    findAll()
 * @method Characters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharactersRepository extends ServiceEntityRepository implements CharacterInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characters::class);
    }

    public function store(Characters $characters): void
    {
        $this->getEntityManager()->persist($characters);
        $this->getEntityManager()->flush();
    }

    public function findOneByName(string $name): ?Characters {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOneById(int $id): Characters
    {
        return $this->find($id);
    }
}
