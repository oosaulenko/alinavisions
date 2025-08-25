<?php

namespace App\Repository\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioCategoryMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioCategoryMedia>
 */
class PortfolioCategoryMediaRepository extends ServiceEntityRepository implements PortfolioCategoryMediaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioCategoryMedia::class);
    }

    public function add(PortfolioCategoryMedia $entity): PortfolioCategoryMedia
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function remove(PortfolioCategoryMedia $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return PortfolioCategoryMedia[] Returns an array of PortfolioCategoryMedia objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PortfolioCategoryMedia
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getByName(string $name, Portfolio $portfolio): ?PortfolioCategoryMedia
    {
        return $this->findOneBy(['name' => $name, 'portfolio' => $portfolio]);
    }
}
