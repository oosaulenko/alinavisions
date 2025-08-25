<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioCategoryMedia;

interface PortfolioCmServiceInterface
{
    public function add(PortfolioCategoryMedia $entity): PortfolioCategoryMedia;

    /**
     * @return PortfolioCategoryMedia[]
     */
    public function bulk_update(Portfolio $portfolio, array $categories): array;
    public function remove(PortfolioCategoryMedia $entity, bool $flush = true): void;

    public function getByName(string $name, Portfolio $portfolio): ?PortfolioCategoryMedia;
}