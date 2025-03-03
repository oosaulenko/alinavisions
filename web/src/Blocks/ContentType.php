<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Form\Type\TitleGroupType;
use App\Service\PostServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContentType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class);

        $builder->add('title', TitleGroupType::class);
        $builder->add('subtitle', TextType::class, ['label' => 'Subtitle', 'required' => false]);
        $builder->add('image', MediaType::class);
        $builder->add('columns', ChoiceType::class, [
            'label' => 'Columns',
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
            ],
            'required' => false,
        ]);
        $builder->add('text', TextEditorType::class, ['label' => 'Text']);
    }

    public static function getName(): string
    {
        return 'Text content';
    }

    public static function getDescription(): string
    {
        return 'Text content block';
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
        return 'blocks/content.html.twig';
    }

    public static function configureAssets(): array
    {
        return [
            'js' => [
                '/build/block-content.js'
            ],
            'css' => [
                '/build/block-content.css'
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-content.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
