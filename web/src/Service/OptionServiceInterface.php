<?php

namespace App\Service;

use App\DTO\SettingsDTO;
use App\Entity\Option;

interface OptionServiceInterface
{
    /**
     * @return Option[]|null
     */
    public function getSettings(): ?array;
    public function getSetting(string $name): ?Option;
    public function getSettingValue(string $name, string $default_value = ''): string;
    public function setSetting(string $name, string $value = null, bool $flush = false): void;
    public function setSettingFormatter(string $name, mixed $value = null, bool $flush = false): void;
    public function save(): void;
    public function fillSettingsDTO(SettingsDTO $settingsDTO): SettingsDTO;
}