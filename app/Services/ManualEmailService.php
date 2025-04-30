<?php

namespace App\Services;

use App\Models\ManualEmailUser;
use App\Models\ManualEmail;
use App\Models\Setting;
use App\Models\User;
use App\Services\Notifications\NotificationService;
use Illuminate\Support\Facades\DB;

class ManualEmailService
{
    private $notificationService;
    private $settings;

    public function __construct(NotificationService $notificationService)
    {
        $this->settings = Setting::first();
        $this->notificationService = $notificationService;
    }

    public function createManualEmail($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new ManualEmail();
            $this->storeManualEmailData($newItem, $data);
            if (in_array("0", $data->input("users"))) {
                $newItem->recipients = 0; //for all users
            } else {
                $newItem->recipients = 1; //for selected multi user
            }
            $newItem->save();

            if (!in_array("0", $data->input("users"))) {
                foreach ($data->users as $oneOption) {
                    $newUser = new ManualEmailUser();
                    $newUser->manual_email_id = $newItem->id;
                    $newUser->user_id = $oneOption;
                    $newUser->save();
                }
            }

            $this->handleManualEmailAction($newItem, $data);
        });
    }

    public function updateManualEmail(ManualEmail $item, $data): void
    {
        DB::transaction(function () use ($item, $data) {
            $this->storeManualEmailData($item, $data);
            if (in_array("0", $data->input("users"))) {
                $item->recipients = 0; //for all users
            } else {
                $item->recipients = 1; //for selected multi user
            }

            $item->save();

            ManualEmailUser::where('manual_email_id', $item->id)->forceDelete();

            if (!in_array("0", $data->input("users"))) {
                foreach ($data->users as $oneOption) {
                    $newUser = new ManualEmailUser();
                    $newUser->manual_email_id = $item->id;
                    $newUser->user_id = $oneOption;
                    $newUser->save();
                }
            }

            $this->handleManualEmailAction($item, $data);
        });
    }

    private function storeManualEmailData(ManualEmail $item, $data): void
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

    private function handleManualEmailAction(ManualEmail $item, $data): void
    {
        if ($data['status'] === 'delivered') {
//            dispatch(function () use ($item) {
                $users = [];

                if ($item->recipients == 0) {
                    // Send to all active users
                    $users = User::active()->get();
                } else {
                    // Send to selected users
                    $userIds = ManualEmailUser::where('manual_email_id', $item->id)
                        ->pluck('user_id')
                        ->toArray();
                    $users = User::active()
                        ->whereIn('id', $userIds)
                        ->get();
                }

                foreach ($users as $user) {
                    $emailData = [
                        'to' => $user->email,
                        'subject' => $item->subject,
                    ];
                    $message = view('website.email', ['item' => $item])->render();
                    $this->notificationService->sendNotification($message, $emailData, 'email');
                }
            $item->total_recipients = count($users);
            $item->save();
//            });
        }
    }
}
