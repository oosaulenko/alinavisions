<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\ButtonGroupType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Service\Package\PackageServiceInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceListType extends AbstractBlockType
{
    public function __construct(protected PackageServiceInterface $packageService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('button', ButtonGroupType::class);
    }

    public static function getName(): string
    {
        return 'Services';
    }

    public static function getDescription(): string
    {
        return 'List of services';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-screwdriver-wrench';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/services.html.twig';
    }

    public static function configureAssets(): array
    {
        $package = new Package(new JsonManifestVersionStrategy(__DIR__ . '/../../public/build/manifest.json'));

        return [
            'js' => [
                $package->getUrl('build/block-services.js')
            ],
            'css' => [
                $package->getUrl('build/block-services.css')
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-services.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        $list_packages = $this->packageService->list([
            'locale' => $_COOKIE['app_locale'] ?? 'uk',
        ]);

        return array_merge($data, [
            'items' => $list_packages
        ]);
    }
}
