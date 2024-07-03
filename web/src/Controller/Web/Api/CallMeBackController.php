<?php

declare(strict_types=1);

namespace App\Controller\Web\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CallMeBackController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    ) { }

    #[Route('/api/call_me_back', name: 'api_call_me_back')]
    public function index(ChatterInterface $chatter, Request $request): Response
    {
        if ($request->request->get('phone') === null || $request->request->get('name') === null) {
            return $this->json([
                'status' => 'error',
                'message' => 'Phone and name are required'
            ], 400);
        }

        $chatMessage = new ChatMessage(
            '<b>🔔‌ Зворотній дзвінок</b>' . PHP_EOL . PHP_EOL .
            '<b>Ім\'я:</b> ' . $request->request->get('name') . PHP_EOL .
            '<b>Телефон:</b> ' . $request->request->get('phone') . PHP_EOL . PHP_EOL .
            '<b>Коментар:</b>' . PHP_EOL . $request->request->get('message')
        );

        $telegramOptions = (new TelegramOptions())
            ->parseMode('HTML')
            ->disableWebPagePreview(true);

        $chatMessage->options($telegramOptions);
        $chatter->send($chatMessage);

        return $this->json([
            'status' => 'success',
            'title' => $this->translator->trans('block.contact_me.modal.title'),
            'message' => $this->translator->trans('block.contact_me.modal.message')
        ]);
    }
}
