<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Repository\PortfolioRepositoryInterface;

class PortfolioService implements PortfolioServiceInterface
{

    public function __construct(
        protected PortfolioRepositoryInterface $repository
    ) { }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function findBySlug(string $slug): ?Portfolio
    {
        return $this->repository->findBySlug($slug);
    }

    public function findById(int $id): ?Portfolio
    {
        return $this->repository->findById($id);
    }

    public function list(array $params = [], int $limit = 10, int $page = 1): array
    {
        return $this->repository->list($params, $limit, $page);
    }
}