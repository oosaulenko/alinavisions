<?php

namespace App\Controller\Admin;

use App\Admin\Field\AccessField;
use App\Admin\Field\DataField;
use App\Admin\Field\StatusField;
use App\Entity\Portfolio;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Admin\Field\Media\LoolyGalleryField;
use App\Admin\Field\Media\LoolyMediaField;

class PortfolioCrudController extends BaseCrudController
{

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Портфоліо')
            ->setPageTitle('detail', fn (Portfolio $portfolio) => (string) $portfolio->getTitle())
            ->setPageTitle('new', 'Створення нового портфоліо')
            ->setPageTitle('edit', 'Редагування портфоліо')
            ->setDefaultSort(['created_at' => 'DESC'])
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        $actions->update('index', 'new', function ($action) {
            return $action->setLabel('Додати');
        });

        $actions->update('new', 'saveAndAddAnother', function ($action) {
            return $action->setLabel('Зберегти та додати ще');
        });

        $actions->update('new', 'saveAndReturn', function ($action) {
            return $action->setLabel('Зберегти');
        });

        $actions->update('detail', 'edit', function ($action) {
            return $action->setLabel('Редагувати');
        });

        $actions->update('detail', 'delete', function ($action) {
            return $action->setLabel('Видалити')->setIcon('fa fa-trash');
        });

        $actions->update('detail', 'index', function ($action) {
            return $action->setLabel('Повернутися до списку');
        });

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = parent::configureFields($pageName);

        $categoryField = AssociationField::new('category')
            ->setColumns(4)->setLabel('Категорія')
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', $this->localeSwitcher->getLocale());
            })
        ;

        $fields[0] = FormField::addTab('Налаштування')->setIcon('fa fa-cog');
        $fields[20] = TextEditorField::new('short_description')->setLabel('Опис')->onlyOnForms()->setColumns(12)->setTrixEditorConfig([
            'blockAttributes' => [
                'default' => ['tagName' => 'p'],
            ],
        ]);

        $fields[21] = $categoryField;
        $fields[22] = TextField::new('location')->setColumns(4)->setLabel('Локація')->hideOnIndex();
        $fields[23] = DateField::new('date')->setColumns(4)->setLabel('Дата зйомки');
        $fields[26] = StatusField::new('status')->setLabel('Статус')->setColumns(4);
        $fields[27] = AccessField::new('access')->setLabel('Доступ')->setColumns(4);
        $fields[28] = DateField::new('hast_at')->setLabel('Доступ для скачування')->setColumns(4);
        $fields[29] = LoolyMediaField::new('image')->setColumns(2);
        $fields[30] = AssociationField::new('photoshoot')->setCrudController(PhotoshootCrudController::class)->setColumns(12)->autocomplete();

        $fields[40] = FormField::addTab('Медіа')->setIcon('fa-solid fa-image');
        $fields[41] = LoolyGalleryField::new('media');

        $fields[80] = FormField::addTab('SEO')->setIcon('fa-solid fa-bullhorn');
        $fields[81] = DataField::new('data')->setLabel(false)->hideOnIndex()->setColumns(12);
        $fields[82] = SlugField::new('slug')->setLabel('Слаг')
            ->onlyOnForms()
            ->setTargetFieldName('title')
            ->setHelp('Слаг для URL')
            ->setColumns(12);


        return $this->sortByKeyFields($fields);
    }
}
