<?php

namespace App\DTO;

class SettingsDTO
{
    public ?string $siteName = '';
    public ?string $siteLogo = null;
    public array $siteLangs = [];
    public string $siteDefaultLang = 'uk';
    public ?string $textCopyright = '';

    public ?array $socials = [];
}