<?php

namespace App\Repository;

use App\Entity\Portfolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Portfolio>
 */
class PortfolioRepository extends ServiceEntityRepository implements PortfolioRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Portfolio::class);
    }

    //    /**
    //     * @return Portfolio[] Returns an array of Portfolio objects
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

    //    public function findOneBySomeField($value): ?Portfolio
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function all(): array
    {
        return $this->findAll();
    }

    public function findBySlug(string $slug, string $locale = 'en'): ?Portfolio
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function findById(int $id): ?Portfolio
    {
        return $this->find($id);
    }

    public function list(array $params = [], int $limit = 10, int $page = 1): array
    {
        $qb = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        if (isset($params['category'])) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $params['category']);
        }

        return $qb->getQuery()->getResult();
    }
}
