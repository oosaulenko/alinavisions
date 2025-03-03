<?php

namespace App\Utility;

interface AutoloadFormInterface
{
    public function autoloadForms(): array;
    public function createForms(): array;
}