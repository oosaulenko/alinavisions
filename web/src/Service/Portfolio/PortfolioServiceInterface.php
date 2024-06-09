<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;

interface PortfolioServiceInterface
{
    /**
     * @return Portfolio[]
     */
    public function all(): array;

    /**
     * @param string $slug
     * @return Portfolio|null
     */
    public function findBySlug(string $slug): ?Portfolio;

    /**
     * @param int $id
     * @return Portfolio|null
     */
    public function findById(int $id): ?Portfolio;

    /**
     * @param array $params
     * @param int $limit
     * @param int $page
     *
     * @return Portfolio[]
     */
    public function list(array $params = [], int $limit = 10, int $page = 1): array;
}