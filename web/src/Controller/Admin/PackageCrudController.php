<?php

namespace App\Controller\Admin;

use App\Admin\Field\DataField;
use App\Admin\Field\StatusField;
use App\Entity\Package;
use App\Form\Type\PriceItemType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Admin\Field\Media\LoolyGalleryField;
use App\Admin\Field\Media\LoolyMediaField;

class PackageCrudController extends BaseCrudController
{

    public static function getEntityFqcn(): string
    {
        return Package::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = parent::configureFields($pageName);

        $categoryField = AssociationField::new('category')
            ->setColumns(6)
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', $this->localeSwitcher->getLocale());
            })
        ;

        $fields[0] = FormField::addTab('General');

        $fields[21] = TextEditorField::new('excerpt')->onlyOnForms()->setColumns(12)->setTrixEditorConfig([
            'blockAttributes' => [
                'default' => ['tagName' => 'p'],
            ],
        ]);

        $fields[22] = TextField::new('price')->setColumns(6);
        $fields[23] = $categoryField;
        $fields[24] = CollectionField::new('prices')
            ->setEntryType(PriceItemType::class)
            ->hideOnIndex()
            ->addCssClass('field-collection-sortable')
            ->setColumns(12);

        $fields[25] = LoolyGalleryField::new('medias');

        $fields[31] = FormField::addTab('Settings')->setIcon('fa fa-cog');
        $fields[38] = FormField::addColumn('col-lg-4 col-xl-4');
        $fields[39] = FormField::addFieldset();
        $fields[42] = StatusField::new('status');
        $fields[44] = LoolyMediaField::new('image');

        $fields[49] = FormField::addFieldset();

        $fields[60] = FormField::addColumn('col-lg-8 col-xl-8');
        $fields[61] = FormField::addFieldset();
        $fields[62] = DataField::new('data')->setLabel(false)->hideOnIndex()->setColumns(12);

        return $this->sortByKeyFields($fields);
    }
}
