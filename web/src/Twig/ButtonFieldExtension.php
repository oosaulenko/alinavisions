<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ButtonFieldExtension extends AbstractExtension
{

    public function __construct(
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('button_field', [$this, 'view'], ['is_safe' => ['html']]),
        ];
    }

    public function view(array $data)
    {
        return $this->twig->render('blocks/component/button.html.twig', $data);
    }
}