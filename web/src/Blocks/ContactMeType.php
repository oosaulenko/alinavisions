<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Service\PostServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Oosaulenko\MediaBundle\Form\Type\MediaChoiceType;
use Oosaulenko\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactMeType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('image', MediaChoiceType::class, ['label' => false]);
    }

    public static function getName(): string
    {
        return 'Contact me';
    }

    public static function getDescription(): string
    {
        return 'Contact me block';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-address-book';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/contact_me.html.twig';
    }

    public static function configureAssets(): array
    {
        return [
            'js' => [
                '/build/block-contact_me.js'
            ],
            'css' => [
                '/build/block-contact_me.css'
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'js' => ['/bundles/oosaulenkomedia/js/media-bundle.js'],
            'css' => [
                '/bundles/oosaulenkomedia/css/manager.css',
                '/build/block-contact_me.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
