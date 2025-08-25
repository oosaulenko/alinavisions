<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Form\FormBuilderInterface;

class ImageType extends AbstractBlockType
{
    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class);

        $builder->add('image', MediaType::class);
    }

    public static function getName(): string
    {
        return 'Image';
    }

    public static function getDescription(): string
    {
        return 'Image block';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-image';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/image.html.twig';
    }

    public static function configureAssets(): array
    {
        $package = new Package(new JsonManifestVersionStrategy(__DIR__ . '/../../public/build/manifest.json'));

        return [
            'js' => [
                $package->getUrl('build/block-image.js')
            ],
            'css' => [
                $package->getUrl('build/block-image.css')
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-image.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
