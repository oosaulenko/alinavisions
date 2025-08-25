<?php

declare(strict_types=1);

namespace App\Controller\Api\Media;

use App\Entity\LoolyMedia\Media;
use App\Repository\Media\Filter\ListFilter;
use App\Service\Folder\FolderServiceInterface;
use App\Service\Media\MediaServiceInterface;
use App\Utility\FileUploader\FileUploaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/media', name: 'api_media_')]
class MediaController extends AbstractController
{
    public function __construct(
        protected FileUploaderInterface $fileUploader,
        protected MediaServiceInterface $mediaService,
        protected FolderServiceInterface $folderService,
    ) {}

    #[Route('/list', name: 'list')]
    public function list(Request $request): JsonResponse
    {
        if($request->query->has('folder') && $request->query->get('folder') !== '0') {
            $folderName = $request->query->get('folder');
            $folder = $this->folderService->findOneByName($folderName);

            if (!$folder) {
                return $this->json([
                    'status' => 'error',
                    'message' => 'Folder not found'
                ]);
            }

            $filter = new ListFilter(
                (int) $request->query->get('limit', 10),
                (int) $request->query->get('page', 1),
                $request->query->all('ids'),
                $folder
            );
        } else {
            $filter = new ListFilter(
                (int) $request->query->get('limit', 10),
                (int) $request->query->get('page', 1),
                $request->query->all('ids')
            );
        }

        $medias = $this->mediaService->findList($filter);

        return $this->json([
            'meta' => [
                'total' => $medias->count(),
            ],
            'data' => $medias
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): JsonResponse
    {
        $inputs = $request->files->all();
        $medias = [];

        foreach ($inputs as $input) {
            if(is_array($input)) {
                $field_name = array_key_first($input);
                $file = $this->fileUploader->upload($input[$field_name]);
            } else {
                $file = $this->fileUploader->upload($input);
            }

            $media = new Media();
            $media->setData($file);
            $medias[] = $media;

            $this->mediaService->add($media);
        }

        $this->mediaService->save();

        return $this->json([
            'data' => $medias
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
        $id = $request->query->get('id');

        if (!$id) {
            return $this->json([
                'status' => 'error',
                'message' => 'Media ID is required'
            ]);
        }

        $this->mediaService->remove($id, true);

        return $this->json([
            'status' => 'success'
        ]);
    }
}
