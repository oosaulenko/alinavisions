<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) { }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('field.name.label', [], 'form'),
                'row_attr' => [
                    'class' => 'form__group size--sm',
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
                'attr' => [
                    'class' => 'form__control',
                    'placeholder' => $this->translator->trans('field.name.placeholder', [], 'form'),
                    'data-message_required' => $this->translator->trans('field.name.message_required', [], 'form'),
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => $this->translator->trans('field.phone.label', [], 'form'),
                'row_attr' => [
                    'class' => 'form__group size--sm',
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
                'attr' => [
                    'class' => 'form__control',
                    'placeholder' => $this->translator->trans('field.phone.placeholder', [], 'form'),
                    'data-message_required' => $this->translator->trans('field.phone.message_required', [], 'form'),
                    'data-validation' => 'phone_email',
                    'data-message_validate' => $this->translator->trans('field.phone.message_validate', [], 'form')
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => $this->translator->trans('field.message.label', [], 'form'),
                'required' => false,
                'row_attr' => [
                    'class' => 'form__group size--sm',
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
                'attr' => [
                    'class' => 'form__control',
                    'placeholder' => $this->translator->trans('field.message.placeholder', [], 'form'),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('button.submit.label', [], 'form'),
                'attr' => [
                    'class' => 'button button-primary button--sm position--center',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form formValidation formContactMe',
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
