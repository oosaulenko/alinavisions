<?php

namespace App\Repository\Page;

use App\Entity\Page;

interface PageRepositoryInterface
{
    /**
     * @return Page[]
     */
    public function all(): array;

    /**
     * @param string $slug
     * @param string $locale
     * @return Page|null
     */
    public function findBySlug(string $slug, string $locale = 'uk'): ?Page;

    /**
     * @param int $id
     * @return Page|null
     */
    public function findById(int $id): ?Page;

    /**
     * @param string $locale
     * @return Page|null
     */
    public function findMainPage(string $locale = 'uk'): ?Page;

    /**
     * @param string $locale
     * @param array $params
     * @return Page[]|null
     */
    public function findByLocale(string $locale, array $params = []): ?array;

}