<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Service\Post\PostServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
    }

    public static function getName(): string
    {
        return 'Blog';
    }

    public static function getDescription(): string
    {
        return 'List posts from blog';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-fire';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/blog.html.twig';
    }

    public static function configureAssets(): array
    {
        return [
            'js' => [
                '/build/block-blog.js'
            ],
            'css' => [
                '/build/block-blog.css'
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-blog.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
