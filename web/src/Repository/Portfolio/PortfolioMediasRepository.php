<?php

namespace App\Repository\Portfolio;

use App\Entity\PortfolioMedias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioMedias>
 */
class PortfolioMediasRepository extends ServiceEntityRepository implements PortfolioMediasRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioMedias::class);
    }

    public function add(PortfolioMedias $entity, bool $flush = true): PortfolioMedias
    {
        $this->getEntityManager()->persist($entity);

        if($flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    public function remove(PortfolioMedias $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
