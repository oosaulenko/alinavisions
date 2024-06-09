<?php

namespace App\Controller\Web\Post;

use App\Service\Portfolio\PortfolioServiceInterface;
use App\Utility\DataEntityViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SinglePortfolioController extends AbstractController
{

    public function __construct(
        protected PortfolioServiceInterface $portfolioService,
        protected DataEntityViewInterface $dataEntityView,
    ) { }

    #[Route('/portfolio/{slug}', name: 'app_portfolio_single')]
    public function index(string $slug): Response
    {
        $portfolio = $this->portfolioService->findBySlug($slug);

        if (!$portfolio) {
            throw $this->createNotFoundException();
        }

        return $this->render('web/portfolio/single.html.twig', array_merge(
            $this->dataEntityView->getMeta($portfolio),
            ['page' => $portfolio],
        ));
    }
}
