<?php

namespace App\Controller\Web\Api\Portfolio;

use App\Service\Portfolio\PortfolioServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

class DownloadController extends AbstractController
{

    public function __construct(
        private PortfolioServiceInterface $portfolioService
    ) { }

    #[Route('/api/portfolio/download', name: 'api_portfolio_download')]
    public function __invoke(Request $request): Response
    {
        $id = $request->query->get('id');

        if ($id === null) {
            return $this->json([
                'status' => 'error',
                'message' => 'Id is required'
            ], 400);
        }

        $portfolio = $this->portfolioService->findById($id);

        $zip_archive = $this->portfolioService->createZipArchive($portfolio);

        $response = new BinaryFileResponse($zip_archive);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $portfolio->getSlug().'_'.date('Y_m_d').'.zip'
        );

        return $response;
    }

}