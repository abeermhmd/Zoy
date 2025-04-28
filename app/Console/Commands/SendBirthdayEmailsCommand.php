<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\EmailText;
use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\Notifications\NotificationService;

class SendBirthdayEmailsCommand extends Command
{
    protected $signature = 'emails:send-birthday';
    protected $description = 'Send birthday emails to users whose birthday is today';
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        try {
            $birthdayEmail = EmailText::active()->where('type', 'Birthday')->first();

            if (!$birthdayEmail) {
                return 0;
            }
            $today = Carbon::now();
            $users = User::active()->whereMonth('date_of_birth', $today->month)
                ->whereDay('date_of_birth', $today->day)
                ->get();

            if ($users->isEmpty()) {
                return 0;
            }

            foreach ($users as $user) {
                try {
                    $emailData = [
                        'to' => $user->email,
                        'subject' => $birthdayEmail->subject,
                    ];

                    $message = $birthdayEmail->content;
                    $this->notificationService->sendNotification($message, $emailData, 'email');
                } catch (Exception $e) {
                }
            }
        } catch (Exception $e) {
        }
        return 0;
    }
}
