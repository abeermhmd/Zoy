<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use App\Models\Cart;
use App\Models\EmailText;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\Notifications\NotificationService;

class AbandonedCartReminderCommand extends Command
{
    protected $signature = 'abandoned-cart:send-reminders';
    protected $description = 'Send email reminders to users who abandoned their cart';

    protected $notificationService;
    protected $settings;
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
        $this->settings = Setting::first();
    }

    public function handle(): int
    {
        try {

            $totalHours = $this->settings->remember_abandoned_cart * 24;
            $diff = Carbon::now()->subHours($totalHours);

            $userIds = Cart::whereNotNull('user_id')
                ->where('updated_at', '<=', $diff)
                ->groupBy('user_id')
                ->pluck('user_id');

            $users = User::active()->whereIn('id', $userIds)->get();
            $emailText = EmailText::active()->where('type', 'abandoned_cart')->first();

            if (!$emailText) {
                return 1;
            }

            foreach ($users as $user) {
                try {
                    $emailData = [
                        'to' => $user->email,
                        'subject' => $emailText->subject,
                    ];

                    $message = view('website.email', ['item' => $emailText])->render();
                    $this->notificationService->sendNotification($message, $emailData, 'email');

                } catch (\Exception $e) {
                    $this->error("Failed to send to {$user->email}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

        return 0;
    }
}
