<?php

namespace App\Twig;

use App\Service\OptionServiceInterface;
use App\Utility\PropertyView;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OptionExtension extends AbstractExtension
{
    use PropertyView;

    public function __construct(
        protected OptionServiceInterface $optionService,
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('option', [$this, 'option'], ['is_safe' => ['html']]),
        ];
    }

    public function option(string $name, bool $template = true)
    {
        $option = $this->optionService->getSetting($name);
        if (!$option) return '';

        $value = $option->getValue();

        if($this->isJsonArray($value)) {
            $value = json_decode($value, true);
        }

        if(!$template) {
            return $value;
        }

        return $this->twig->render('web/component/option.html.twig', [
            'option' => $value
        ]);
    }
}