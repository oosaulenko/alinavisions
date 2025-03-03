<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FilterFieldExtension extends AbstractExtension
{

    public function __construct(
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('filter_field', [$this, 'view'], ['is_safe' => ['html']]),
        ];
    }

    public function view(array $data, ?string $template)
    {
        if ($template) {
            $template = '_by_' . $template;
        }

        return $this->twig->render('blocks/component/filter' . $template . '.html.twig', [
            'list' => $data
        ]);
    }
}