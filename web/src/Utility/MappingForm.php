<?php

namespace App\Utility;

use App\Form\CertificateType;
use App\Form\ContactType;
use App\Form\PackageType;

trait MappingForm
{

    public function getForm($name): ?string
    {
        $forms = [
            'package' => PackageType::class,
            'certificate' => CertificateType::class,
            'contact' => ContactType::class,
        ];

        return $forms[$name] ?? null;
    }

    public function getMessageTitle($formName): ?string
    {
        $titles = [
            'package' => 'Замовлення пакету послуг',
            'certificate' => 'Замовлення сертифікату',
            'contact' => 'Зворотній зв\'язок',
        ];

        return $titles[$formName] ?? null;
    }

    public function getMessageFieldLine($key): ?string
    {
        $messages = [
            'name' => 'Ім\'я:',
            'phone' => 'Телефон:',
            'message' => 'Коментар:',
            'package_name' => 'Послуга:',
        ];

        return $messages[$key] ?? null;
    }
}