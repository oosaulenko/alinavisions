<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => true,
            'choices' => [
                'Закрита' => 'close',
                'Пряме посилання' => 'direct_link',
                'Публічно' => 'public',
            ],
            'default_value' => 'close',
        ]);
    }

    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}
