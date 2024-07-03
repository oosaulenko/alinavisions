<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TitleGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'label' => 'Text',
                'help' => 'The text of the title',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'help' => 'The type of the title',
                'choices' => [
                    'h1' => 'h1',
                    'h2' => 'h2',
                    'h3' => 'h3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'Title',
            'required' => false,
            'row_attr' => [
                'class' => 'form-group--title',
            ]
        ]);
    }
}
