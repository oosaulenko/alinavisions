<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Package;
use App\Entity\Page;
use App\Entity\Photoshoot;
use App\Entity\Portfolio;
use App\Entity\Post;
use App\Entity\User;
use App\Service\OptionServiceInterface;
use App\Utility\LanguagesInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        protected LanguagesInterface $languages,
        protected OptionServiceInterface $optionService
    ) { }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->optionService->getSetting('siteName') ?
                $this->optionService->getSetting('siteName')->getValue() : 'Skeleton Panel')
            ->setLocales($this->languages->getSupportLangs())
            ;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addWebpackEncoreEntry('admin')
            ->addWebpackEncoreEntry('block-editor-container')
            ->addCssFile('/bundles/loolymedia/css/looly-media-bundle.css')
            ->addJsFile('/bundles/loolymedia/js/looly-media-bundle.js')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Сторінки', 'fa fa-file-lines', Page::class);
        yield MenuItem::linkToRoute('Медіа', 'fa fa-picture-o', 'looly_media_list');

        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Портфоліо', 'fa fa-briefcase', Portfolio::class);
        yield MenuItem::linkToCrud('Фотосесії', 'fa fa-images', Photoshoot::class);
        yield MenuItem::linkToCrud('Послуги', 'fa fa-cube', Package::class);
//        yield MenuItem::linkToCrud('Статті', 'fa fa-file-lines', Post::class);
        yield MenuItem::linkToCrud('Категорії', 'fa fa-tags', Category::class);

        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Меню', 'fa fa-bars-staggered', Menu::class);
        yield MenuItem::linkToRoute('Налаштування', 'fa fa-cog', 'admin_settings')->setPermission('ROLE_ADMIN');

        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Користувачі', 'fa fa-user', User::class);
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
