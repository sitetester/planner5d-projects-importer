<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectThumbnail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectThumbnail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectThumbnail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectThumbnail[]    findAll()
 * @method ProjectThumbnail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectThumbnailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectThumbnail::class);
    }
}
