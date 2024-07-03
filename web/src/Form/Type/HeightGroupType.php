<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeightGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mobile', TextType::class, [
                'label' => 'Mobile',
            ])
            ->add('tablet', TextType::class, [
                'label' => 'Tablet',
            ])
            ->add('desktop', TextType::class, [
                'label' => 'Desktop',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Height',
            'required' => false,
            'row_attr' => [
                'class' => 'form-group--basic',
            ]
        ]);
    }
}
