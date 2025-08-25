<?php

namespace App\Repository\Package;

use App\Entity\Package;

interface PackageRepositoryInterface
{
    /**
     * @return Package[]
     */
    public function all(): array;

    /**
     * @param string $slug
     * @param string $locale
     *
     * @return Package|null
     */
    public function findBySlug(string $slug, string $locale = 'en'): ?Package;

    /**
     * @param int $id
     *
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