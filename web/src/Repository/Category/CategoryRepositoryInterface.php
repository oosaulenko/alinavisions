<?php

namespace App\Repository\Category;

use App\Entity\Category;

interface CategoryRepositoryInterface
{

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param string $slug
     * @param string $locale
     * @return Category|null
     */
    public function findBySlug(string $slug, string $locale = 'uk'): ?Category;

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed;

}