<?php

namespace App\Form\DataTransformer;

use App\Entity\LoolyMedia\Media;
use App\Service\Media\MediaServiceInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaTypeTransformer implements DataTransformerInterface
{

    public function __construct(
        private MediaServiceInterface $mediaService
    ) { }

    public function transform($value): mixed
    {
        if($value === null) {
            return null;
        }

        $media = $this->mediaService->findOneById($value);

        return $media;
    }

    public function reverseTransform(mixed $value): mixed
    {
        if(!$value) {
            return null;
        }

        if($value instanceof Media) {
            $value = $value->getId();
        }

        $media = $this->mediaService->findOneById($value);

        if(!$media) {
            throw new TransformationFailedException(sprintf('Media with id "%s" does not exist!', $value));
        }

        return $value;
    }
}