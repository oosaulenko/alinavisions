<?php

namespace App\Form;

use Looly\Media\Form\Type\MediaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SocialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telegram', TextType::class, [
                'label' => 'Telegram',
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
            ->add('instagram', TextType::class, [
                'label' => 'Instagram',
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
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
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
        ;
    }
}
