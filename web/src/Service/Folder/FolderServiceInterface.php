<?php

namespace App\Service\Folder;

use App\Entity\LoolyMedia\Folder;

interface FolderServiceInterface
{
    public function add(Folder $entity, bool $flush = false): void;

    public function update(Folder $entity, bool $flush = false): void;

    public function remove(string|int|Folder $entity, bool $flush = false): void;

    public function save(): void;

    /**
     * @return Folder[]|null
     */
    public function all(): ?array;

    /**
     * @param int $id
     * @return Folder|null
     */
    public function findOneByName(string $name): ?Folder;
}