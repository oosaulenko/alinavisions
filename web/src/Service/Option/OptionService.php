<?php

namespace App\Service\Option;

use App\DTO\SettingsDTO;
use App\Entity\Option;
use App\Repository\Option\OptionRepositoryInterface;
use App\Utility\PropertyView;
use ReflectionClass;

class OptionService implements OptionServiceInterface
{
    use PropertyView;

    public function __construct(
        protected OptionRepositoryInterface $repository
    ) { }

    public function getSettings(): ?array
    {
        return $this->repository->getSettings();
    }

    public function getSetting(string $name): ?Option
    {
        return $this->repository->getSetting($name);
    }

    public function getSettingValue(string $name, string $default_value = ''): string
    {
        $option = $this->repository->getSetting($name);

        return ($option && $option->getValue()) ? $option->getValue() : $default_value;
    }

    public function setSetting(string $name, string $value = null, bool $flush = false): void
    {
        $this->repository->setSetting($name, $value, $flush);
    }

    public function setSettingFormatter(string $name, mixed $value = null, bool $flush = false): void
    {
        if(is_array($value)) {
            $value = json_encode($value);
        }

        $this->setSetting($name, $value, $flush);
    }

    public function save(): void
    {
        $this->repository->save();
    }

    public function fillSettingsDTO(SettingsDTO $settingsDTO): SettingsDTO
    {
        $reflectionClass = new ReflectionClass($settingsDTO);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $name = $property->getName();

            if(!$this->getSetting($name)) {
                continue;
            }

            $value = $this->getSetting($name)->getValue();

            if ($this->isJsonArray($value)) {
                $value = json_decode($value, true);
            }

            $property->setValue($settingsDTO, $value);
        }

        return $settingsDTO;
    }
}