<?php

namespace App\Controller\Admin;

use App\DTO\SettingsDTO;
use App\Form\SettingsType;
use App\Service\Option\OptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    public function __construct(
        protected OptionServiceInterface $optionService
    ) { }

    #[Route('/admin/settings/', name: 'admin_settings')]
    public function __invoke(Request $request, FormFactoryInterface $formFactory): Response
    {
        $settingsDto = new SettingsDTO();
        $this->optionService->fillSettingsDTO($settingsDto);

        $form = $formFactory->create(SettingsType::class, $settingsDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fields = $form->all();

            foreach ($fields as $key => $value) {
                $this->optionService->setSettingFormatter($key, $value->getData());
            }

            $this->optionService->save();
            $this->addFlash('success', 'Settings updated successfully');
        }

        return $this->render('admin/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}