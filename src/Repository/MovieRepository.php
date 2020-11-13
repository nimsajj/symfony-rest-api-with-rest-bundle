<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Movie::class);
        $this->manager = $manager;
    }

    public function save(Movie $movie): Movie
    {
        $this->manager->persist($movie);
        $this->manager->flush();

        return $movie;
    }

    public function remove(Movie $movie): void
    {
        $this->manager->remove($movie);
        $this->manager->flush();
    }
}
