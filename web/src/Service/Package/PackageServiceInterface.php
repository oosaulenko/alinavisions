<?php

namespace App\Service\Package;

use App\Entity\Package;

interface PackageServiceInterface
{
    /**
     * @return Package[]
     */
    public function all(): array;

    /**
     * @param string $slug
     * @return Package|null
     */
    public function findBySlug(string $slug): ?Package;

    /**
     * @param int $id
     * @return Package|null
     */
    public function findById(int $id): ?Package;

    /**
     * @param array $params
     * @param int $limit
     * @param int $page
     *
     * @return Package[]
     */
    public function list(array $params = [], int $limit = 10, int $page = 1): array;
}