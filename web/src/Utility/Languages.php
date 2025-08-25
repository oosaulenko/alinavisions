<?php

namespace App\Utility;

use App\Service\Option\OptionServiceInterface;

class Languages implements LanguagesInterface
{

    private array $langs = [
        'en' => 'English',
        'uk' => 'Українська',
        'fr' => 'France',
        'de' => 'Germany',
        'es' => 'Spain',
        'it' => 'Italy',
        'pl' => 'Poland',
        'ru' => 'Russian',
        'tr' => 'Turkey',
    ];

    public function __construct(
        protected OptionServiceInterface $optionService
    ) { }

    public function getLanguages(bool $revert = false): array
    {
        if ($revert) {
            return array_flip($this->langs);
        }

        return $this->langs;
    }

    public function getSupportLangs(bool $revert = false): array
    {
        if(!$this->optionService->getSetting('siteLangs')) return [];

        $langs = [];
        $siteLangs = json_decode($this->optionService->getSetting('siteLangs')->getValue());
        $languages = $this->getLanguages();

        foreach ($siteLangs as $lang) {
            $langs[$lang] = $languages[$lang];
        }

        if ($revert) {
            return array_flip($langs);
        }

        return $langs;
    }
}