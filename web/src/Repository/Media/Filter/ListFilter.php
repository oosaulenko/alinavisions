<?php

namespace App\Repository\Media\Filter;

use App\Entity\LoolyMedia\Folder;

class ListFilter
{
    public function __construct(
        private int $limit,
        private int $page = 1,
        private array $excludeIds = [],
        private ?Folder $folder = null
    ) {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function excludeIds(): array
    {
        return $this->excludeIds;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }
}