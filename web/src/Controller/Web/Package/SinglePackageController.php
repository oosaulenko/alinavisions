<?php

namespace App\Controller\Web\Package;

use App\Form\PackageType;
use App\Service\Package\PackageServiceInterface;
use App\Service\Portfolio\PortfolioServiceInterface;
use App\Utility\DataEntityViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SinglePackageController extends AbstractController
{

    public function __construct(
        protected PackageServiceInterface $packageService,
        protected DataEntityViewInterface $dataEntityView,
        protected PortfolioServiceInterface $portfolioService
    ) { }

    #[Route('/package/{slug}', name: 'app_package_single')]
    public function index(string $slug): Response
    {
        $package = $this->packageService->findBySlug($slug);

        if (!$package) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(PackageType::class);
        $form->setData([
            'package_name' => $package->getTitle(),
        ]);

        $portfolios = $this->portfolioService->list([
            'category' => $package->getCategory(),
            'status' => 'published',
        ], 18);

        return $this->render('web/package/single.html.twig', array_merge(
            $this->dataEntityView->getMeta($package),
            [
                'page' => $package,
                'portfolios' => $portfolios,
                'form' => $form,
            ],
        ));
    }
}
