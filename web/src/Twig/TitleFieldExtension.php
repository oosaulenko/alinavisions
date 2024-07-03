<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TitleFieldExtension extends AbstractExtension
{

    public function __construct(
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('title_field', [$this, 'view'], ['is_safe' => ['html']]),
        ];
    }

    public function view(array $data)
    {
        return $this->twig->render('blocks/component/title.html.twig', $data);
    }
}