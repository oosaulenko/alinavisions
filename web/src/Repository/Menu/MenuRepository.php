<?php

namespace App\Repository\Menu;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 */
class MenuRepository extends ServiceEntityRepository implements MenuRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function getMenu(string $location, string $locale = 'uk'): ?Menu
    {
        return $this->findOneBy([
            'location' => $location,
            'locale' => $locale,
        ]);
    }
}
