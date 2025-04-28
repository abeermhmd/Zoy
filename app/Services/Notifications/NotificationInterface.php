<?php
///////(open/closed Principle from SOLID)

namespace App\Services\Notifications;

interface NotificationInterface {
    public function send($message, array $data = []);
}
