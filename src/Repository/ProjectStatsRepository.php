<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectStats[]    findAll()
 * @method ProjectStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectStats::class);
    }
}
