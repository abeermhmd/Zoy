<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\EmailText;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\Notifications\NotificationService;

class ContinueOrderReminderCommand extends Command
{
    protected $signature = 'continue-order:send-reminders';
    protected $description = 'Send email reminders to users who abandoned their order';

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
            $totalHours = $this->settings->remember_continue_order * 24;
            $diff = Carbon::now()->subHours($totalHours);

            $orders = Order::where('payment_status', 0)->whereNotNull('user_id')
                ->where('created_at', '<=', $diff)->get();

            $emailText = EmailText::active()->where('type', 'continue_order')->first();

            if (!$emailText) {
                return 1;
            }

            $userIds = $orders->pluck('user_id')->unique()->toArray();
            $users = User::active()->whereIn('id', $userIds)->get();

            foreach ($users as $user) {
                foreach ($orders as $order) {
                    if ($order->user_id == $user->id) {
                        try {
                            $emailData = [
                                'to' => $user->email,
                                'subject' => $emailText->subject,
                            ];

                            $message = view('website.email', ['item' => $emailText])->render();
                            $this->notificationService->sendNotification($message, $emailData, 'email');

                        } catch (\Exception $e) {
                            $this->error("Failed to send to {$user->email} (Order ID {$order->id}): " . $e->getMessage());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
        return 0;
    }
}
