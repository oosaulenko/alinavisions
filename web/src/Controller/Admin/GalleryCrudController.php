<?php

namespace App\Controller\Admin;

use App\Admin\Field\AccessField;
use App\Admin\Field\DataField;
use App\Admin\Field\StatusField;
use App\Admin\Field\TitleField;
use App\Entity\LoolyMedia\Media;
use App\Entity\Portfolio;
use App\Entity\PortfolioCategoryMedia;
use App\Entity\PortfolioMedias;
use App\Service\Portfolio\PortfolioCmServiceInterface;
use App\Service\Portfolio\PortfolioMediasServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Admin\Field\Media\LoolyGalleryField;
use App\Admin\Field\Media\LoolyMediaField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class GalleryCrudController extends AbstractCrudController
{
    private ?string $section = null;

    public function __construct(
        protected PortfolioCmServiceInterface $portfolioCmService,
        protected PortfolioMediasServiceInterface $portfolioMediasService,
        private EntityManagerInterface $em,
        private AdminUrlGenerator $adminUrlGenerator
    ) {}

    public static function getEntityFqcn(): string
    {
        return Portfolio::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->addFormTheme('form/form_theme.html.twig')
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Портфоліо')
            ->setPageTitle('detail', fn (Portfolio $portfolio) => (string) $portfolio->getTitle())
            ->setPageTitle('new', 'Створення нового портфоліо')
            ->setPageTitle('edit', fn (Portfolio $portfolio) => 'Редагування - ' . $portfolio->getTitle())
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

        $entity_type = new (static::getEntityFqcn())();

        if(method_exists($entity_type, '_actions')) {
            foreach ($entity_type->_actions() as $type => $action) {
                if($type == 'view') {
                    $action = Action::new('view', 'Переглянути')
                        ->addCssClass('text-success')
                        ->setIcon('fa fa-eye')
                        ->setHtmlAttributes(['target' => '_blank'])
                        ->linkToUrl(fn ($entity) =>
                            '/portfolio/' . $entity->getSlug()
                        );
                    $actions->add(Crud::PAGE_INDEX, $action);
                    $actions->add(Crud::PAGE_EDIT, $action);
                }

                if($type == 'download_link') {
                    $action = Action::new('download_link', 'Лінк на завантаження')
                        ->addCssClass('text-primary')
                        ->setIcon('fa fa-download')
                        ->setHtmlAttributes(['target' => '_blank'])
                        ->displayIf(fn ($entity) => $entity->getHash())
                        ->linkToUrl(fn ($entity) =>
                            '/portfolio/' . $entity->getSlug() . '?hash=' . $entity->getHash()
                        );
                    $actions->add(Crud::PAGE_INDEX, $action);
                    $actions->add(Crud::PAGE_EDIT, $action);
                }
            }
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_NEW) {
            return $this->configureFieldsNew();
        }

        if ($pageName === Crud::PAGE_EDIT) {
            return $this->configureFieldsEdit();
        }

        if ($pageName === Crud::PAGE_INDEX) {
            return $this->configureFieldsIndex();
        }

        return [
            TitleField::new('title')->setLabel('Назва'),
        ];
    }

    private function configureFieldsNew(): array
    {
        $categoryField = AssociationField::new('category')
            ->setColumns(4)->setLabel('Категорія')
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', 'uk');
            })
        ;

        return [
            TitleField::new('title')->setLabel('Назва'),
            TextEditorField::new('short_description')->setLabel('Опис')->onlyOnForms()->setColumns(12)->setTrixEditorConfig([
                'blockAttributes' => [
                    'default' => ['tagName' => 'p'],
                ],
            ]),
            $categoryField,
            TextField::new('location')->setColumns(4)->setLabel('Локація')->hideOnIndex(),
            DateField::new('date')->setColumns(4)->setLabel('Дата зйомки'),
            SlugField::new('slug')->setLabel('Слаг')->onlyOnForms()->setTargetFieldName('title')->setHelp('Слаг для URL')->setColumns(12)
        ];
    }

    private function configureFieldsEdit(): array
    {
        $categoryField = AssociationField::new('category')
            ->setColumns(4)->setLabel('Категорія')
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', 'uk');
            })
        ;

        $entity = $this->getContext()->getEntity()->getInstance();
        $entityId = $entity?->getId();

        if($entity->getPortfolioCategoryMedia()) {
            $portfolioCategoriesMedia = [];
            foreach ($entity->getPortfolioCategoryMedia() as $portfolioCategoryMedia) {
                $portfolioCategoriesMedia[$portfolioCategoryMedia->getSort()] = $portfolioCategoryMedia->getName();
            }

            ksort($portfolioCategoriesMedia);
        }

        if($entity->getPortfolioMedias()) {
            $portfolioMediaItems = [];
            foreach ($entity->getPortfolioMedias() as $portfolioMedia) {
                $categoryMediaName = $portfolioMedia->getCategory() ? $portfolioMedia->getCategory()->getName() . '_' : '';
                $portfolioMediaItems[$categoryMediaName . $portfolioMedia->getSort()] = $portfolioMedia;
            }

            ksort($portfolioMediaItems);
        }

        return [
            FormField::addTab('Медіа')->setIcon('fa-solid fa-image'),
            ChoiceField::new('category_media_items')->setFormTypeOptions([
                'mapped' => false,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ])->addCssClass('is-hidden'),
            ChoiceField::new('category_media')->setFormTypeOptions([
                'mapped' => false,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ])->addCssClass('is-hidden'),
            LoolyGalleryField::new('media', false, $entityId)
                ->setFormTypeOption('categories', $portfolioCategoriesMedia)
                ->setFormTypeOption('medias', $portfolioMediaItems)
            ,
            FormField::addTab('Контент')->setIcon('fa-solid fa-file-lines'),
            TitleField::new('title')->setLabel('Назва'),
            TextEditorField::new('short_description')->setLabel('Опис')->onlyOnForms()->setColumns(12)->setTrixEditorConfig([
                'blockAttributes' => [
                    'default' => ['tagName' => 'p'],
                ],
            ]),
            $categoryField,
            TextField::new('location')->setColumns(4)->setLabel('Локація')->hideOnIndex(),
            DateField::new('date')->setColumns(4)->setLabel('Дата зйомки'),
            SlugField::new('slug')->setLabel('Слаг')->onlyOnForms()->setTargetFieldName('title')->setHelp('Слаг для URL')->setColumns(12),
            FormField::addTab('Налаштування')->setIcon('fa-solid fa-cog'),
            LoolyMediaField::new('image')->setColumns(2),
            AssociationField::new('photoshoot')->setCrudController(PhotoshootCrudController::class)->setColumns(12)->autocomplete()->setLabel('Фотосесія для клієнта'),
            StatusField::new('status')->setLabel('Статус')->setColumns(4),
            AccessField::new('access')->setLabel('Доступ')->setColumns(4),
            DateField::new('hast_at')->setLabel('Доступ для скачування')->setColumns(4),
            FormField::addTab('SEO')->setIcon('fa-solid fa-bullhorn'),
            DataField::new('data')->setLabel(false)->hideOnIndex()->setColumns(12),
        ];
    }

    private function configureFieldsIndex(): array
    {
        $categoryField = AssociationField::new('category')
            ->setColumns(4)->setLabel('Категорія')
            ->setQueryBuilder(function ($repository) {
                return $repository
                    ->where('entity.locale = :locale')
                    ->setParameter('locale', 'uk');
            })
        ;

        return [
            TitleField::new('title')->setLabel('Назва'),
            DateField::new('date')->setColumns(4)->setLabel('Дата зйомки'),
            $categoryField,
            StatusField::new('status')->setLabel('Статус')->setColumns(4),
            AccessField::new('access')->setLabel('Доступ')->setColumns(4),
        ];
    }

    public function createEditFormBuilder(EntityDto $entityDto, $formOptions, AdminContext $context): FormBuilderInterface
    {
        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (isset($data['category_media_items'])) {
                $selected = $data['category_media_items'];
                if (!\is_array($selected)) {
                    $selected = [$selected];
                }

                $choices = array_combine($selected, $selected);
                $form->add('category_media_items', ChoiceType::class, [
                    'mapped'   => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'choices'  => $choices,
                ]);
            }

            if (isset($data['category_media'])) {
                $selected = $data['category_media'];
                if (!\is_array($selected)) {
                    $selected = [$selected];
                }

                $choices = array_combine($selected, $selected);
                $form->add('category_media', ChoiceType::class, [
                    'mapped'   => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'choices'  => $choices,
                ]);
            }

        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form   = $event->getForm();
            /** @var Portfolio $entity */
            $entity = $event->getData();

            if (!$form->isValid()) {
                return;
            }

            $categoriesMedia = $this->portfolioCmService->bulk_update($entity, $form->get('category_media')->getData());
            $this->portfolioMediasService->bulk_update($entity, $form->get('category_media_items')->getData(), $categoriesMedia);

            $this->em->flush();
        });

        return $builder;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $relativeLocales = $entityInstance->getRelativeLocales();

        foreach ($relativeLocales as &$locale) {
            if($locale['locale'] == 'uk') {
                $locale['entity'] = $entityInstance->getId();
            }
        }

        $entityInstance->setRelativeLocales($relativeLocales);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setAccess('close');
        $entityInstance->setStatus('draft');
        $entityInstance->setCreatedAt(new \DateTimeImmutable());
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        $entityInstance->setHash();
        $entityInstance->setLocale('uk');
        $entityInstance->setRelativeLocales([
            [
                'locale' => 'uk',
                'entity' => null,
            ],
            [
                'locale' => 'en',
                'entity' => ''
            ]
        ]);

        parent::persistEntity($entityManager, $entityInstance);
    }

}