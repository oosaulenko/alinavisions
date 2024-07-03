<?php

namespace App\Controller\Web\Portfolio;

use App\Service\Portfolio\PortfolioServiceInterface;
use App\Utility\DataEntityViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SinglePortfolioController extends AbstractController
{

    public function __construct(
        protected PortfolioServiceInterface $portfolioService,
        protected DataEntityViewInterface $dataEntityView,
    ) { }

    #[Route('/portfolio/{slug}', name: 'app_portfolio_single')]
    public function index(Request $request, string $slug): Response
    {
        $portfolio = $this->portfolioService->findBySlug($slug);

        if (!$portfolio) {
            throw $this->createNotFoundException();
        }

        if (!$this->getUser() && ($portfolio->getAccess() == 'close' || $portfolio->getStatus() != 'published')) {
            throw $this->createNotFoundException();
        }

        if(!$this->getUser() && $portfolio->getAccess() == 'direct_link' && !$request->query->get('hash')) {
            throw $this->createNotFoundException();
        }

        if($request->query->get('hash') && $request->query->get('hash') === $portfolio->getHash()) {
            $linkToDownload = true;
        }

        return $this->render('web/portfolio/single.html.twig', array_merge(
            $this->dataEntityView->getMeta($portfolio),
            [
                'page' => $portfolio,
                'link_to_download' => $linkToDownload ?? false
            ],
        ));
    }
}
