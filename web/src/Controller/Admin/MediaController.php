<?php

namespace App\Controller\Admin;

use App\Repository\Media\Filter\ListFilter;
use App\Service\Folder\FolderServiceInterface;
use App\Service\Media\MediaServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    public function __construct(
        private MediaServiceInterface $service,
        private FolderServiceInterface $folderService,
    ) { }

    #[Route('/admin/medias/', name: 'admin_media_list')]
    public function __invoke(): Response
    {
        $filter = new ListFilter(
            24
        );

        $medias = $this->service->findList($filter);
        $folders = $this->folderService->all();

        return $this->render('admin/media.html.twig', [
            'medias' => $medias,
            'folders' => $folders
        ]);
    }
}