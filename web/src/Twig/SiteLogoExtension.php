<?php

namespace App\Twig;

use App\Service\Media\MediaServiceInterface;
use App\Service\Option\OptionServiceInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SiteLogoExtension extends AbstractExtension
{
    public function __construct(
        protected OptionServiceInterface $optionService,
        protected MediaServiceInterface $mediaService,
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('site_logo', [$this, 'view'], ['is_safe' => ['html']]),
        ];
    }

    public function view()
    {
        $logoId = $this->optionService->getSetting('siteLogo');
        if (!$logoId || empty($logoId->getValue())) return '';

        $logo = $this->mediaService->findOneById($logoId->getValue());
        if (!$logo) return '';

        return $this->twig->render('web/component/logo.html.twig', [
            'logo' => $logo
        ]);
    }
}