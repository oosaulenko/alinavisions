<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Form\Type\HeightGroupType;
use App\Form\Type\TitleGroupType;
use App\Service\PostServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        return [
            'js' => [
                '/build/block-image.js'
            ],
            'css' => [
                '/build/block-image.css'
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
