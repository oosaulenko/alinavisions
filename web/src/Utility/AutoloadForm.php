<?php

namespace App\Utility;

use App\Form\CertificateType;
use App\Form\ContactType;
use Symfony\Component\Form\FormFactoryInterface;

class AutoloadForm implements AutoloadFormInterface
{

    public function __construct(
        protected FormFactoryInterface $formFactory
    ) {}

    public function autoloadForms(): array
    {
        return [
            'formCertificate' => CertificateType::class,
            'formContact' => ContactType::class,
        ];
    }

    public function createForms(): array
    {
        $forms = [];
        foreach ($this->autoloadForms() as $formName => $formClass) {
            $forms[$formName] = $this->formFactory->create($formClass)->createView();
        }
        return $forms;
    }
}