<?php

namespace App\Form;

use App\Form\DataTransformer\MediaTypeTransformer;
use App\Form\Type\MediaType;
use App\Service\Media\MediaServiceInterface;
use App\Utility\LanguagesInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingsType extends AbstractType
{
    public function __construct(
        protected LanguagesInterface $languages,
        protected MediaServiceInterface $mediaService
    ) { }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mediaTypeTransformer = new MediaTypeTransformer($this->mediaService);

        $builder
            ->add('siteName', TextType::class, [
                'label' => 'Site name',
                'row_attr' => [
                  'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('siteLogo', MediaType::class, [
                'label' => 'Logo',
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
            ])
            ->add('siteLangs', ChoiceType::class, [
                'label' => 'Languages support',
                'expanded' => true,
                'row_attr' => [
                    'class' => 'form-group field-siteLangs',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'multiple' => true,
                'choices' => $this->languages->getLanguages(true),
            ])
            ->add('siteDefaultLang', ChoiceType::class, [
                'label' => 'Default language',
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => $this->languages->getLanguages(true),
            ])
            ->add('textCopyright', TextType::class, [
                'label' => 'Copyright text',
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('socials', SocialType::class, [
                'label' => 'Socials',
                'row_attr' => [
                    'class' => 'form-group field-socials',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
            ])
        ;

        $builder->get('siteLogo')->addModelTransformer($mediaTypeTransformer);
    }
}
