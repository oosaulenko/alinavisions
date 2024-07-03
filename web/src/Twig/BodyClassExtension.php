<?php

namespace App\Twig;

use App\Service\BodyClassServiceInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BodyClassExtension extends AbstractExtension
{

    public function __construct(
        private readonly BodyClassServiceInterface $bodyClassService
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('body_class', [$this, 'getBodyClass']),
        ];
    }

    public function getBodyClass(): string
    {
        return $this->bodyClassService->getBodyClass();
    }

}