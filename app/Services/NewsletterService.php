<?php

namespace App\Services;

use App\Models\Newsletter;
use App\Models\Setting;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use App\Services\Notifications\NotificationService;

class NewsletterService
{
    private $notificationService;
    private $settings;
    public function __construct(NotificationService $notificationService)
    {
        $this->settings = Setting::first();
        $this->notificationService = $notificationService;
    }

    public function createNewsletter($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Newsletter();
            $this->storeNewsletterData($newItem, $data);
            $newItem->save();

            $this->handleNewsletterAction($newItem, $data);
        });
    }

    public function updateNewsletter(Newsletter $item, $data): void
    {
        DB::transaction(function () use ($item, $data) {
            $this->storeNewsletterData($item, $data);
            $item->save();
            $this->handleNewsletterAction($item, $data);
        });
    }

    private function storeNewsletterData(Newsletter $item, $data): void
    {
        storeTranslatedFields($item, ['subject', 'content'], $data);

        $item->status = $data['status'];
        if ($data['status'] === 'scheduled' && isset($data['date']) && isset($data['time'])) {
            $item->date = $data['date'];
            $item->time = $data['time'];
        } else {
            $item->date = null;
            $item->time = null;
        }
    }

    private function handleNewsletterAction(Newsletter $item, $data): void
    {
        if ($data['status'] === 'delivered') {
            $subscribers =  Subscriber::active()->get();;
            foreach ($subscribers as $subscriber) {
                $emailData = [
                    'to' => $subscriber->email,
                    'subject' => $item->subject,
                ];
                $message = view('website.email', ['item' => $item])->render();
                $this->notificationService->sendNotification($message, $emailData, 'email');
            }
        }
    }
}
