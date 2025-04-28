<?php
///////(open/closed Principle from SOLID)
namespace App\Services\Notifications;

use Illuminate\Support\Facades\Mail;

class EmailNotification implements NotificationInterface {

    public function send($message, array $data = []) {
        $email_data = [
            'from' => env('MAIL_FROM_ADDRESS'),
            'to' => [$data['to']],
            'subject' => $data['subject'] ?? 'Email'
        ];

        Mail::send([], [], function ($mail) use ($email_data, $message) {
            $mail->to($email_data['to'])
                 ->subject($email_data['subject'])
                ->html($message)
                ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
