<?php

namespace App\Controller\Admin;

use App\Entity\Photoshoot;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Looly\Media\Admin\Field\LoolyGalleryField;

class PhotoshootCrudController extends BaseCrudController
{

    public static function getEntityFqcn(): string
    {
        return Photoshoot::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = parent::configureFields($pageName);

        $fields[0] = FormField::addTab('General');
        $fields[25] = LoolyGalleryField::new('media');

        return $this->sortByKeyFields($fields);
    }
}
