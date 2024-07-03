<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ButtonGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'help' => 'The name of the button',
            ])
            ->add('link', TextType::class, [
                'label' => 'Link',
                'help' => 'The link of the button',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'help' => 'The type of the button',
                'choices' => [
                    'primary' => 'primary',
                    'outline' => 'outline',
                    'link' => 'link',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Button',
            'required' => false,
            'row_attr' => [
                'class' => 'form-group--button',
            ]
        ]);
    }
}
