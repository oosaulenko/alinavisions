<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioCategoryMedia;
use App\Repository\Portfolio\PortfolioCategoryMediaRepositoryInterface;

class PortfolioCategoryMediaService implements PortfolioCmServiceInterface
{
    public function __construct(
        protected PortfolioCategoryMediaRepositoryInterface $repository
    ) { }

    public function add(PortfolioCategoryMedia $entity): PortfolioCategoryMedia
    {
        return $this->repository->add($entity);
    }

    /**
     * @return PortfolioCategoryMedia[]
     */
    public function bulk_update(Portfolio $portfolio, array $categories): array
    {
        $categoriesResponse = [];
        $categoriesMedia = $portfolio->getCategoriesMedia();

        foreach ($categories as $sort => $category_name) {
            if(isset($categoriesMedia[$category_name])) {
                if($categoriesMedia[$category_name]->getSort() != $sort) {
                    $categoriesMedia[$category_name]->setSort($sort);
                }

                $categoriesResponse[$categoriesMedia[$category_name]->getName()] = $categoriesMedia[$category_name];
            } else {
                $portfolioCategoryMedia = new PortfolioCategoryMedia();
                $portfolioCategoryMedia->setName($category_name);
                $portfolioCategoryMedia->setPortfolio($portfolio);
                $portfolioCategoryMedia->setSort($sort);
                $categoryMedia = $this->add($portfolioCategoryMedia);
                $categoriesResponse[$categoryMedia->getName()] = $categoryMedia;
            }
        }

//        foreach ($categoriesMedia as &$categoryMedia) {
//            if(!in_array($categoryMedia->getName(), $categories)) {
//                $categoriesResponse[$categoryMedia->getName()]->setStatus('deleted');
//            }
//        }

        return $categoriesResponse;
    }

    public function remove(PortfolioCategoryMedia $entity, bool $flush = true): void
    {
        $this->repository->remove($entity, $flush);
    }

    public function getByName(string $name, Portfolio $portfolio): ?PortfolioCategoryMedia
    {
        return $this->repository->getByName($name, $portfolio);
    }
}