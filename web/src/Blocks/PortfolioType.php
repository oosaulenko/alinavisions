<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\Type\ButtonGroupType;
use App\Form\Type\DefaultSettingsBlockType;
use App\Service\Portfolio\PortfolioServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PortfolioType extends AbstractBlockType
{
    public function __construct(protected PortfolioServiceInterface $portfolioService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, [
            'label' => 'Title',
            'required' => false,
        ]);
        $builder->add('text', TextEditorType::class, [
            'label' => 'Text',
            'required' => false,
        ]);
        $builder->add('limit', TextType::class, [
            'label' => 'Limit',
            'required' => false,
        ]);
        $builder->add('button', ButtonGroupType::class);
    }

    public static function getName(): string
    {
        return 'Portfolio';
    }

    public static function getDescription(): string
    {
        return 'View portfolio items';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-briefcase';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/portfolio.html.twig';
    }

    public static function configureAssets(): array
    {
        return [
            'js' => [
                '/build/block-portfolio.js'
            ],
            'css' => [
                '/build/block-portfolio.css'
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'css' => [
                '/build/block-portfolio.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        $limit = (!empty($data['limit'])) ? $data['limit'] : 100;

        $list_portfolio = $this->portfolioService->list([
            'status' => 'published',
            'access' => 'public'
        ], $limit);

        return array_merge($data, [
            'items' => $list_portfolio
        ]);
    }
}
