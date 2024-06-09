<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
            'status_code' => 404,
            'status_text' => 'Not Found',
        ]);
    }
}