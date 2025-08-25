<?php

namespace App\Repository\Folder;

use App\Entity\LoolyMedia\Folder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FolderRepository extends ServiceEntityRepository implements FolderRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Folder::class);
    }

    public function add(Folder $entity, bool $flush = false): void
    {
        $entity->setUpdatedAt(new \DateTimeImmutable());
        $this->getEntityManager()->persist($entity);

        if ($flush) $this->save();
    }

    public function update(Folder $entity, bool $flush = false): void
    {
        if ($entity->getId() === null) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
            $this->add($entity, $flush);
        } else {
            if($flush) $this->save();
        }
    }

    public function remove(Folder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) $this->save();
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function all(): ?array
    {
        return self::findBy([], ['name' => 'ASC']);
    }

    public function findOneByName(string $name): ?Folder
    {
        return self::findOneBy(['name' => $name]);
    }
}