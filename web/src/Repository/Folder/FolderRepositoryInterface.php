<?php

namespace App\Repository\Folder;


use App\Entity\LoolyMedia\Folder;

interface FolderRepositoryInterface
{
    /**
     * @param Folder $entity
     * @param bool $flush
     * @return void
     */
    public function add(Folder $entity, bool $flush = false): void;

    /**
     * @param Folder $entity
     * @param bool $flush
     * @return void
     */
    public function update(Folder $entity, bool $flush = false): void;

    /**
     * @param Folder $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Folder $entity, bool $flush = false): void;

    /**
     * @return void
     */
    public function save(): void;

    /**
     * @return Folder[]|null
     */
    public function all(): ?array;

    /**
     * @param string $name
     * @return Folder|null
     */
    public function findOneByName(string $name): ?Folder;
}