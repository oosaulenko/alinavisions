<?php

namespace App\Admin\Field\Media;

use App\Form\Type\MediaType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class LoolyMediaField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|true|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->hideOnIndex()
            ->setColumns(12)

            ->setFormType(MediaType::class)
            ->addCssClass('lm-field-media')
            ;
    }
}