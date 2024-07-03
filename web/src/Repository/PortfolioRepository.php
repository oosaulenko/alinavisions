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

        if (isset($params['status'])) {
            $qb->andWhere('p.status = :status')
                ->setParameter('status', $params['status']);
        }

        if (isset($params['access'])) {
            $qb->andWhere('p.access = :access')
                ->setParameter('access', $params['access']);
        }

        return $qb->getQuery()->getResult();
    }
}
