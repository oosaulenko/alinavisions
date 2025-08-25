<?php

namespace App\Service\Folder;

use App\Entity\LoolyMedia\Folder;
use App\Repository\Folder\FolderRepositoryInterface;

class FolderService implements FolderServiceInterface
{
    public function __construct(
        protected FolderRepositoryInterface $repository
    ) { }

    public function add(Folder $entity, bool $flush = false): void
    {
        $this->repository->add($entity, $flush);
    }

    public function update(Folder $entity, bool $flush = false): void
    {
        $this->repository->update($entity, $flush);
    }

    public function remove(string|int|Folder $entity, bool $flush = false): void
    {
        if (is_int($entity) || is_string($entity)) {
            $entity = $this->repository->findOneByName($entity);
        }

        $this->repository->remove($entity, $flush);
    }

    public function save(): void
    {
        $this->repository->save();
    }

    public function all(): ?array
    {
        return $this->repository->all();
    }

    public function findOneByName(string $name): ?Folder
    {
        return $this->repository->findOneByName($name);
    }
}