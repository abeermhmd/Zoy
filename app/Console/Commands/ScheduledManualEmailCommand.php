<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\ManualEmail;
use App\Models\ManualEmailUser;
use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\Notifications\NotificationService;

class ScheduledManualEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manual-email:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled manual emails that are due to be sent';

    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @param NotificationService $notificationService
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        try {
            $emails = ManualEmail::where('status', 'scheduled')
                ->whereDate('date', '<=', $today)
                ->where(function ($query) use ($today, $currentTime) {
                    $query->where('date', '<', $today)
                        ->orWhere(function ($query) use ($currentTime) {
                            $query->where('time', '<=', $currentTime);
                        });
                })
                ->get();

            if ($emails->isEmpty()) {
                return 0;
            }

            foreach ($emails as $email) {

                try {
                    $users = [];

                    if ($email->recipients == 0) {
                        $users = User::active()->get();
                    } else {
                        $userIds = ManualEmailUser::where('manual_email_id', $email->id)
                            ->pluck('user_id')
                            ->toArray();
                        $users = User::active()
                            ->whereIn('id', $userIds)
                            ->get();
                    }

                    if ($users->isEmpty()) {
                        return 0;
                    }

                    foreach ($users as $user) {
                        try {
                            $emailData = [
                                'to' => $user->email,
                                'subject' => $email->subject,
                            ];

                            $message = view('website.email', ['item' => $email])->render();
                            $this->notificationService->sendNotification($message, $emailData, 'email');
                        } catch (Exception $e) {
                            $this->error('Error sending email to ' . $user->email . ': ' . $e->getMessage());
                        }
                    }

                    $email->status = 'delivered';
                    $email->save();
                } catch (Exception $e) {
                    $this->error("Error processing email ID: {$email->id}: " . $e->getMessage());
                }
            }
        } catch (Exception $e) {
            $this->error('General error: ' . $e->getMessage());
        }
        return 0;
    }
}
