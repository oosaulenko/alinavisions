<?php

namespace App\Controller\Admin;

use App\Admin\Field\AccessField;
use App\Admin\Field\DataField;
use App\Admin\Field\StatusField;
use App\Entity\Portfolio;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Looly\Media\Admin\Field\LoolyGalleryField;
use Looly\Media\Admin\Field\LoolyMediaField;

class PortfolioCrudController extends BaseCrudController
{

    public static function getEntityFqcn(): string
    {
        return Portfolio::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = parent::configureFields($pageName);

        $categoryField = AssociationField::new('category')
            ->setColumns(12)
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', $this->localeSwitcher->getLocale());
            })
        ;

        $fields[0] = FormField::addTab('General');

        $fields[21] = TextEditorField::new('short_description')->onlyOnForms()->setColumns(12)->setTrixEditorConfig([
            'blockAttributes' => [
                'default' => ['tagName' => 'p'],
            ],
        ]);
        $fields[22] = TextField::new('client')->setColumns(5);
        $fields[23] = TextField::new('location')->setColumns(5);
        $fields[24] = DateField::new('date')->setColumns(2);

        $fields[25] = LoolyGalleryField::new('media');
        $fields[26] = AssociationField::new('photoshoot')->setCrudController(PhotoshootCrudController::class)->setColumns(12)->autocomplete();
//        $fields[26] = AssociationField::new('photoshoot')->setColumns(12);

        $fields[31] = FormField::addTab('Settings')->setIcon('fa fa-cog');
        $fields[38] = FormField::addColumn('col-lg-4 col-xl-4');
        $fields[39] = FormField::addFieldset();
        $fields[41] = $categoryField;
        $fields[42] = StatusField::new('status');
        $fields[43] = AccessField::new('access');
        $fields[44] = DateField::new('hast_at')->setLabel('Access for download')->setColumns(12);
        $fields[45] = LoolyMediaField::new('image');

        $fields[49] = FormField::addFieldset();

        $fields[60] = FormField::addColumn('col-lg-8 col-xl-8');
        $fields[61] = FormField::addFieldset();
        $fields[62] = DataField::new('data')->setLabel(false)->hideOnIndex()->setColumns(12);

        return $this->sortByKeyFields($fields);
    }
}
