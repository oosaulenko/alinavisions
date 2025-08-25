<?php

namespace App\Service\Post;

use App\Repository\Post\PostRepositoryInterface;

class PostService implements PostServiceInterface
{

    public function __construct(
        protected PostRepositoryInterface $repository
    ) { }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->repository->all();
    }

    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug): mixed
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): mixed
    {
        return $this->repository->findById($id);
    }
}