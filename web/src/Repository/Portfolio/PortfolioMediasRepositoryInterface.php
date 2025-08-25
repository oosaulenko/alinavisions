<?php

namespace App\Repository\Portfolio;

use App\Entity\PortfolioMedias;

interface PortfolioMediasRepositoryInterface
{
    public function add(PortfolioMedias $entity, bool $flush = true): PortfolioMedias;
    public function remove(PortfolioMedias $entity): void;
}