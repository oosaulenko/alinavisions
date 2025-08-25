<?php

declare(strict_types=1);

namespace App\Controller\Api\Portfolio;

use App\Entity\PortfolioCategoryMedia;
use App\Service\Media\MediaServiceInterface;
use App\Service\Portfolio\PortfolioCmServiceInterface;
use App\Service\Portfolio\PortfolioServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/portfolio/media/', name: 'api_portfolio_media_')]
class PortfolioMediasController extends AbstractController
{
    public function __construct(
        protected PortfolioServiceInterface   $portfolioService,
        protected MediaServiceInterface       $mediaService,
        protected PortfolioCmServiceInterface $portfolioCategoryMediaService,
    ) {}

    #[Route('/add', name: 'add')]
    public function add(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        $portfolioId = $request->query->get('portfolioId');

        if (!$name || !$portfolioId) {
            return $this->json([
                'status' => 'error',
                'message' => 'Name and Portfolio ID are required'
            ]);
        }

        $portfolio = $this->portfolioService->findById((int) $portfolioId);
        if (!$portfolio) {
            return $this->json([
                'status' => 'error',
                'message' => 'Portfolio not found'
            ]);
        }

        $portfolioCategoryMedia = new PortfolioCategoryMedia();
        $portfolioCategoryMedia->setName($name);
        $portfolioCategoryMedia->setPortfolio($portfolio);
        $portfolioCategoryMedia->setSort(1);
        $this->portfolioCategoryMediaService->add($portfolioCategoryMedia);

        return $this->json([
            'status' => 'success',
            'message' => 'Portfolio category media added successfully',
            'data' => [
                'id' => $portfolioCategoryMedia->getId(),
            ]
        ]);
    }

    #[Route('/remove', name: 'remove')]
    public function remove(Request $request): JsonResponse
    {
        return $this->json([ ]);
    }
}
