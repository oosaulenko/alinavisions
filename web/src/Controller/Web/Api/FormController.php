<?php

declare(strict_types=1);

namespace App\Controller\Web\Api;

use App\Utility\MappingForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormController extends AbstractController
{
    use MappingForm;

    public function __construct(
        private TranslatorInterface $translator
    ) { }

    #[Route('/api/form', name: 'api_form')]
    public function index(ChatterInterface $chatter, Request $request): Response
    {
        $formType = current($request->request->keys());
        $message = '';

        if(!$formType) {
            return $this->json([
                'status' => 'error',
                'message' => 'Form type is required'
            ], 400);
        }

        $formName = $this->getForm($formType);
        $form = $this->createForm($formName);
        $form->handleRequest($request);

        if(!$form->isValid()) {
            return $this->json([
                'status' => 'error',
                'message' => 'Form is not valid',
                'errors' => $form->getErrors(true, false)
            ]);
        }

        $fields = $request->request->all($formType);

        if(!$fields) {
            return $this->json([
                'status' => 'error',
                'message' => 'Fields are empty',
                'fields' => $fields
            ]);
        }

        if($this->getMessageTitle($formType)) {
            $message .= '<b>' . $this->getMessageTitle($formType) . '</b>' . PHP_EOL . PHP_EOL;
        }

        foreach ($fields as $key => $value) {
            if(!$this->getMessageFieldLine($key) || !$value) continue;
            $message .= '<b>'.$this->getMessageFieldLine($key) . '</b> ' . $value . PHP_EOL;
        }

        $chatMessage = new ChatMessage($message);
        $telegramOptions = (new TelegramOptions())
            ->parseMode('HTML')
            ->disableWebPagePreview(true);
        $chatMessage->options($telegramOptions);

        try {
            $chatter->send($chatMessage);

            return $this->json([
                'status' => 'success',
                'message' => $this->translator->trans('message.success', [], 'form')
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
