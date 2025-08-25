<?php

namespace App\Service\BodyClass;

use Symfony\Component\HttpFoundation\RequestStack;

class BodyClassService implements BodyClassServiceInterface
{

    public function __construct(
        private RequestStack $requestStack
    ) { }

    public function getBodyClass(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $routeName = $request->attributes->get('_route');

        return !$routeName ? 'page-error404': $routeName;
    }
}