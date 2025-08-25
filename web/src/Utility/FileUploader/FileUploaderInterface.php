<?php

namespace App\Utility\FileUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    /**
     * @param UploadedFile $file
     * @return array|null
     */
    public function upload(UploadedFile $file): ?array;
}