<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use Exception;
use Illuminate\Console\Command;
use App\Models\Newsletter;
use Carbon\Carbon;
use App\Services\Notifications\NotificationService;

class ScheduledNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled newsletters that are due to be sent';

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
            $newsletters = Newsletter::where('status', 'scheduled')
                ->whereDate('date', '<=', $today)
                ->where(function ($query) use ($today, $currentTime) {
                    $query->where('date', '<', $today)
                        ->orWhere(function ($query) use ($currentTime) {
                            $query->where('time', '<=', $currentTime);
                        });
                })->get();


            if ($newsletters->isEmpty()) {
                $this->info('No newsletters to process.');
                return 0;
            }

            foreach ($newsletters as $newsletter) {
                try {
                    $subscribers = Subscriber::active()->get();

                    if ($subscribers->isEmpty()) {
                       return  0;
                    }

                    foreach ($subscribers as $subscriber) {
                        try {
                            $emailData = [
                                'to' => $subscriber->email,
                                'subject' => $newsletter->subject,
                            ];

                            $message = view('website.email', ['item' => $newsletter])->render();
                            $this->notificationService->sendNotification($message, $emailData, 'email');
                        } catch (Exception $e) {
                            $this->error('Error preparing email for ' . $subscriber->email . ': ' . $e->getMessage());
                        }
                    }

                    $newsletter->status = 'delivered';
                    $newsletter->save();
                } catch (Exception $e) {
                    $this->error("Error processing newsletter ID: {$newsletter->id}: " . $e->getMessage());
                }
            }
        } catch (Exception $e) {
            $this->error('General error: ' . $e->getMessage());
        }

        return 0;
    }


}
