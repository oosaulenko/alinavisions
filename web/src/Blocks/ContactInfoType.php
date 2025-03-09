<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Form\ContactType;
use App\Form\Type\DefaultSettingsBlockType;
use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;

class ContactInfoType extends AbstractBlockType
{
    public function __construct(
        protected FormFactoryInterface $formFactory
    ) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('email', TextType::class, ['label' => 'Email']);
        $builder->add('location', TextType::class, ['label' => 'Location']);
    }

    public static function getName(): string
    {
        return 'Contact info';
    }

    public static function getDescription(): string
    {
        return 'Contact info block';
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
        return 'blocks/contact_info.html.twig';
    }

    public static function configureAssets(): array
    {
        $package = new Package(new JsonManifestVersionStrategy(__DIR__ . '/../../public/build/manifest.json'));

        return [
            'js' => [
                $package->getUrl('build/block-contact_info.js')
            ],
            'css' => [
                $package->getUrl('build/block-contact_info.css')
            ],
        ];
    }

    public static function configureAdminAssets(): array
    {
        return [
            'js' => [

            ],
            'css' => [
                '/build/block-contact_info.css'
            ],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}
