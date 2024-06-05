<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Form\Type\ServiceCollectionType;
use App\Service\PostServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceListType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('list', CollectionType::class, [
            'label' => 'Services',
            'entry_type' => ServiceCollectionType::class,
            'attr' => [
                'class' => 'field-collection field-collection-sortable',
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ]);
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
        return [
            'js' => [
                '/build/block-services.js'
            ],
            'css' => [
                '/build/block-services.css'
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'js' => ['/bundles/oosaulenkomedia/js/media-bundle.js'],
            'css' => [
                '/bundles/oosaulenkomedia/css/manager.css',
                '/build/block-services.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
