<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Entity\PortfolioMedias;
use App\Repository\Portfolio\PortfolioMediasRepositoryInterface;
use App\Service\Media\MediaServiceInterface;

class PortfolioMediasService implements PortfolioMediasServiceInterface
{
    public function __construct(
        protected PortfolioMediasRepositoryInterface $repository,
        protected PortfolioCmServiceInterface $portfolioCmService,
        protected MediaServiceInterface $mediaService,
    ) { }

    public function add(PortfolioMedias $entity, bool $flush = true): PortfolioMedias
    {
        return $this->repository->add($entity, $flush);
    }

    /**
     * @return PortfolioMedias[]
     */
    public function bulk_update(Portfolio $portfolio, array $medias, array $categories = []): array
    {
        $groupedMedias = $portfolio->getMedias();

        foreach ($medias as $sort => $media) {
            $media = explode('_', $media);
            [$categoryName, $mediaId] = $media;

            if(!isset($categories[$categoryName]) && $categoryName != 'none') {
                $this->portfolioCmService->remove($groupedMedias[$categoryName]->getCategory(), false);
                $categoryName = 'none';
            }

            if(isset($groupedMedias[$categoryName][$mediaId])) {
                if($groupedMedias[$categoryName][$mediaId]->getSort() != $sort) {
                    $groupedMedias[$categoryName][$mediaId]->setSort($sort);
                }
            } else {
                $newMedia = true;

                foreach ($groupedMedias as $name => $categoryMedias) {
                    if(isset($categoryMedias[$mediaId])) {
                        if($categoryName == 'none') {
                            $categoryMedias[$mediaId]->setCategory(null);
                        } else {
                            $categoryMedias[$mediaId]->setCategory($categories[$categoryName]);
                        }

                        $categoryMedias[$mediaId]->setSort($sort);
                        $newMedia = false;
                        break;
                    }
                }

                if(!$newMedia) {
                    continue;
                }

                $portfolioMedia = new PortfolioMedias();
                $portfolioMedia->setPortfolio($portfolio);
                $portfolioMedia->setMedia($this->mediaService->findOneById($mediaId));
                $portfolioMedia->setSort($sort);

                if($categoryName != 'none' && isset($categories[$categoryName])) {
                    $portfolioMedia->setCategory($categories[$categoryName]);
                }

                $this->add($portfolioMedia, false);
            }
        }

        foreach ($groupedMedias as $categoryName => $categoryMedias) {
            foreach ($categoryMedias as $portfolioMedia) {
                if(!in_array($portfolioMedia->getMedia()->getId(), array_map(fn($m) => explode('_', $m)[1], $medias))) {
                    $this->remove($portfolioMedia);
                }
            }

            if(!isset($categories[$categoryName]) && $categoryName != 'none') {
                $categoryRemove = $this->portfolioCmService->getByName($categoryName, $portfolio);
                if($categoryRemove) {
                    $this->portfolioCmService->remove($categoryRemove, false);
                }
            }
        }

        return [];
    }

    public function remove(PortfolioMedias $entity): void
    {
        $this->repository->remove($entity);
    }
}