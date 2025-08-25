<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => 'App\Entity\LoolyMedia\Media',
            'multiple' => true,
            'required' => false,
            'entity_id' => null,
            'categories' => null,
            'medias' => null,
        ]);
        $resolver->setAllowedTypes('entity_id', ['null','int','string']);
        $resolver->setAllowedTypes('categories', ['null','array']);
        $resolver->setAllowedTypes('medias', ['null','array']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['entity_id'] = $options['entity_id'];
        $view->vars['categories'] = $options['categories'];
        $view->vars['medias'] = $options['medias'];
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
