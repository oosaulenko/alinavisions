<?php

namespace App\Repository\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioCategoryMedia;

interface PortfolioCategoryMediaRepositoryInterface
{
    public function add(PortfolioCategoryMedia $entity): PortfolioCategoryMedia;
    public function remove(PortfolioCategoryMedia $entity, bool $flush = true): void;
    public function getByName(string $name, Portfolio $portfolio): ?PortfolioCategoryMedia;
}