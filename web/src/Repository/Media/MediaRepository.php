<?php

namespace App\Repository\Media;

use App\Entity\LoolyMedia\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Media\Filter\ListFilter;

class MediaRepository extends ServiceEntityRepository implements MediaRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Media::class);
    }

    public function add(Media $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) $this->save();
    }

    public function update(Media $entity, bool $flush = false): void
    {
        if ($entity->getId() === null) {
            $this->add($entity, $flush);
        } else {
            if($flush) $this->save();
        }
    }

    public function remove(Media $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) $this->save();
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function list(int $limit, int $offset = 0): ?array
    {
        return $this->createQueryBuilder('m')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findList(ListFilter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('m');

        if ($filter->getLimit() > 0) {
            $qb->setMaxResults($filter->getLimit());
            $qb->setFirstResult(($filter->getPage() - 1) * $filter->getLimit());
        }

        if($filter->excludeIds()) {
            $qb->andWhere('m.id NOT IN (:ids)')
                ->setParameter('ids', $filter->excludeIds());
        }

        if ($filter->getFolder()) {
            $qb->andWhere('m.media_folder = :folder')
                ->setParameter('folder', $filter->getFolder());
        } else {
            $qb->andWhere('m.media_folder IS NULL');
        }

        $qb->orderBy('m.id', 'DESC');

        return new Paginator($qb->getQuery());
    }

    public function countList(): int
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneById(int $id): ?Media
    {
        return self::findOneBy(['id' => $id]);
    }
}