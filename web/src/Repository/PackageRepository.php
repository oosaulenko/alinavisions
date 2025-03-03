<?php

namespace App\Repository;

use App\Entity\Package;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Package>
 */
class PackageRepository extends ServiceEntityRepository implements PackageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Package::class);
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function findBySlug(string $slug, string $locale = 'en'): ?Package
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function findById(int $id): ?Package
    {
        return $this->find($id);
    }

    public function list(array $params = [], int $limit = 10, int $page = 1): array
    {
        $qb = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        if($params) {
            foreach ($params as $key => $value) {
                $qb->andWhere("p.$key = :$key")
                    ->setParameter($key, $value);
            }
        }

        return $qb->getQuery()->getResult();
    }
}
