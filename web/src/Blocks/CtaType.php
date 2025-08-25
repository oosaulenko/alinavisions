<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\ButtonGroupType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Service\Post\PostServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CtaType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('text', TextEditorType::class, ['label' => 'Text']);
        $builder->add('button', ButtonGroupType::class, ['label' => 'Button']);
        $builder->add('image', MediaType::class);
    }

    public static function getName(): string
    {
        return 'CTA';
    }

    public static function getDescription(): string
    {
        return 'CTA block';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-bolt';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/cta.html.twig';
    }

    public static function configureAssets(): array
    {
        $package = new Package(new JsonManifestVersionStrategy(__DIR__ . '/../../public/build/manifest.json'));

        return [
            'js' => [
                $package->getUrl('build/block-cta.js')
            ],
            'css' => [
                $package->getUrl('build/block-cta.css')
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-cta.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
