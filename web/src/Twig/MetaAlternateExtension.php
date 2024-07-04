<?php

namespace App\Twig;

use App\Utility\LanguagesInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MetaAlternateExtension extends AbstractExtension
{
    public function __construct(
        protected LanguagesInterface $languages,
        protected Environment $twig
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('meta_alternate', [$this, 'view'], ['is_safe' => ['html']]),
        ];
    }

    public function view($entity): string
    {
        if(!$entity->getRelativeLocales()) return '';

        $supportedLangs = $this->languages->getSupportLangs();
        $langs = [];

        foreach ($entity->getRelativeLocales() as $relativeLocale) {
            $locale = $relativeLocale['locale'];
            $_entity = $relativeLocale['entity'];

            if (!isset($supportedLangs[$locale]) || !$_entity) continue;

            $slug = (method_exists($entity, 'isMain') && $entity->isMain()) ? '' : '/' . $entity->getSlug();
            $lang = ($locale == 'uk') ? '' : '/' . $locale;

            if(method_exists($entity, '_getSection')) {
                $langs[$locale] = 'https://' . $_SERVER['HTTP_X_FORWARDED_HOST'] . $lang . '/' . $entity->_getSection() . $slug . '/';
            } else {
                $langs[$locale] = 'https://' . $_SERVER['HTTP_X_FORWARDED_HOST'] . $lang . $slug . '/';
            }
        }

        return $this->twig->render('web/component/meta_alternate.html.twig', [
            'langs' => $langs,
            'canonical' => $langs[$entity->getLocale()],
            'locale' => $entity->getLocale().'_'.strtoupper($entity->getLocale())
        ]);
    }
}