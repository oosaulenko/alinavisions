<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => true,
            'choices' => [
                'Чернетка' => 'draft',
                'Опубліковано' => 'published',
                'Архів' => 'archived',
            ],
            'default_value' => 'published',
        ]);
    }

    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}
