<?php
namespace App\Services\Notifications;

class SmsNotification implements NotificationInterface {

    public function send($message, array $data = []) {
        $ch = curl_init();
        $payload = "AppSid=g9X11HAoeK16Pb3I0mqaHZsOK_LIaR&Recipient=" . $data['mobile'] . "&Body=" . $message;

        curl_setopt($ch, CURLOPT_URL, "https://api.unifonic.com/rest/Messages/Send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
