<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioMedias;

interface PortfolioMediasServiceInterface
{
    public function add(PortfolioMedias $entity, bool $flush = true): PortfolioMedias;

    /**
     * @return PortfolioMedias[]
     */
    public function bulk_update(Portfolio $portfolio, array $medias, array $categories = []): array;
    public function remove(PortfolioMedias $entity): void;
}