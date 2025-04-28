<?php
namespace App\Services\Notifications;
use Http;

class PushNotification implements NotificationInterface {

    public function send($message, array $data = []) {
        $headers = [
            'Authorization: key='.env("FireBaseKey"),
            'Content-Type: application/json'
        ];

        $payload = [
            "registration_ids" => $data['tokens'],
            "data" => array_merge([
                'body' => $message,
                'type' => "notify",
                'badge' => 1,
                "click_action" => 'FLUTTER_NOTIFICATION_CLICK',
                'icon' => 'myicon',
                'sound' => 'mySound'
            ], $data),
            "notification" => [
                'body' => $message,
                'title' => $data['title'] ?? 'Notification',
                'target_id' => $data['target_id'] ?? null,
                'msgType' => $data['msgType'] ?? 1,
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        curl_close($ch);

        // return $result;
    }

}
