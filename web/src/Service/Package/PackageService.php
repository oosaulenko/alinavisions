<?php

namespace App\Service\Package;

use App\Entity\Package;
use App\Repository\Package\PackageRepositoryInterface;

class PackageService implements PackageServiceInterface
{
    public function __construct(
        protected PackageRepositoryInterface $repository
    ) { }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function findBySlug(string $slug): ?Package
    {
        return $this->repository->findBySlug($slug);
    }

    public function findById(int $id): ?Package
    {
        return $this->repository->findById($id);
    }

    public function list(array $params = [], int $limit = 10, int $page = 1): array
    {
        return $this->repository->list($params, $limit, $page);
    }
}