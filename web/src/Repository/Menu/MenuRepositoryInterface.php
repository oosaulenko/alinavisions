<?php

namespace App\Repository\Menu;

use App\Entity\Menu;

interface MenuRepositoryInterface
{

    /**
     * @param string $location
     * @param string $locale
     * @return ?Menu
     */
    public function getMenu(string $location, string $locale = 'uk'): ?Menu;

}