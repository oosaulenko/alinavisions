<?php

declare(strict_types=1);

namespace App\Controller\Api\Media;

use App\Entity\LoolyMedia\Folder;
use App\Service\Folder\FolderServiceInterface;
use App\Service\Media\MediaServiceInterface;
use App\Utility\FileUploader\FileUploaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/folder', name: 'api_folder_')]
class FolderController extends AbstractController
{
    public function __construct(
        protected FileUploaderInterface $fileUploader,
        protected MediaServiceInterface $mediaService,
        protected FolderServiceInterface $folderService,
    ) {}

    #[Route('/list', name: 'list')]
    public function list(Request $request): JsonResponse
    {
        $folders = $this->folderService->all();

        return $this->json([
            'meta' => [
                'total' => count($folders),
            ],
            'data' => $folders
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        if (!$name) {
            return $this->json([
                'status' => 'error',
                'message' => 'Name is required'
            ]);
        }

        $folder = $this->folderService->findOneByName($name);

        if ($folder) {
            return $this->json([
                'status' => 'error',
                'message' => 'Folder already exists'
            ]);
        }

        $folder = new Folder();
        $folder->setName($name);
        $this->folderService->add($folder, true);

        return $this->json([
            'status' => 'success'
        ]);
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request): JsonResponse
    {
        return $this->json([ ]);
    }

    #[Route('/remove', name: 'remove')]
    public function remove(Request $request): JsonResponse
    {
        return $this->json([ ]);
    }

    #[Route('/add_media', name: 'add_media')]
    public function add_media(Request $request): JsonResponse
    {
        $media_ids = $request->query->get('ids');
        $folder_name = $request->query->get('folder_name');

        if (!$media_ids || !$folder_name) {
            return $this->json([
                'status' => 'error',
                'message' => 'Media IDs and folder name are required'
            ]);
        }

        $folder = $this->folderService->findOneByName($folder_name);

        $media_ids = explode(',', $media_ids);
        foreach ($media_ids as $media_id) {
            $media = $this->mediaService->findOneById((int) $media_id);
            if (!$media) continue;

            $folder->addMedia($media);
        }

        $this->folderService->save();

        return $this->json([
            'status' => 'success'
        ]);
    }
}
