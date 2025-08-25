<?php

namespace App\Admin\Field\Media;

use App\Form\Type\GalleryType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class LoolyGalleryField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|true|null $label
     */
    public static function new(string $propertyName, $label = null, int $entity_id = 0): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->hideOnIndex()
            ->setColumns(12)
            ->setFormTypeOption('entity_id', $entity_id)

            ->setFormType(GalleryType::class)
            ->addCssClass('lm-field-gallery')
            ;
    }
}