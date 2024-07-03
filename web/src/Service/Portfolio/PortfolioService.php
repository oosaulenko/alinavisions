<?php

namespace App\Service\Portfolio;

use App\Entity\Portfolio;
use App\Repository\PortfolioRepositoryInterface;

class PortfolioService implements PortfolioServiceInterface
{

    public function __construct(
        protected PortfolioRepositoryInterface $repository
    ) { }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function findBySlug(string $slug): ?Portfolio
    {
        return $this->repository->findBySlug($slug);
    }

    public function findById(int $id): ?Portfolio
    {
        return $this->repository->findById($id);
    }

    public function list(array $params = [], int $limit = 10, int $page = 1): array
    {
        return $this->repository->list($params, $limit, $page);
    }

    public function createZipArchive(Portfolio $portfolio): string
    {
        $zip = new \ZipArchive();
        $zipName = $portfolio->getSlug() . '.zip';
        $zipPath = sys_get_temp_dir() . '/' . $zipName;
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($portfolio->getMedia() as $media) {
            $zip->addFromString($media->getName(), file_get_contents($media->getFolder() . $media->getName()));
        }

//        foreach ($portfolio->getMedia() as $media) {
//            $zip->addFromString($media->getName(), file_get_contents($media->getFolder()));
//        }

        $zip->close();

        return $zipPath;
    }
}