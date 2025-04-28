<?php
///////(open/closed Principle + Liskov Substitution Principle from SOLID)

namespace App\Services\Notifications;

use App\Services\Notifications\{PushNotification , SmsNotification , EmailNotification};


class NotificationService {

    protected $pushNotification;
    protected $smsNotification;
    protected $emailNotification;

    public function __construct(PushNotification $pushNotification, SmsNotification $smsNotification, EmailNotification $emailNotification)
    {
        $this->pushNotification = $pushNotification;
        $this->smsNotification = $smsNotification;
        $this->emailNotification = $emailNotification;
    }

    public function sendNotification($message, array $data = [], $type = 'push')
    {
        switch ($type) {
            case 'sms':
                return $this->smsNotification->send($message, $data);
            case 'email':
                return $this->emailNotification->send($message, $data);
            default:
                return $this->pushNotification->send($message, $data);
        }
    }
}
////// هذه طريقة الاستخدام داخل الكنترولر
// namespace App\Http\Controllers;

// use App\Services\NotificationService;
// use Illuminate\Http\Request;

// class UserController extends Controller
// {
//     protected $notificationService;

//     public function __construct(NotificationService $notificationService)
//     {
//         $this->notificationService = $notificationService;
//     }

//     public function sendNotification(Request $request)
//     {
//         $message = $request->input('message');
//         $type = $request->input('type'); // نوع الإشعار المطلوب
//         $data = [
//             'tokens' => $request->input('tokens'),
//             'target_id' => $request->input('target_id'),
//             'title' => $request->input('title'),
//             'msgType' => $request->input('msgType'),
//             'mobile' => $request->input('mobile'),
//             'to' => $request->input('email')
//         ];

//         $this->notificationService->sendNotification($message, $data, $type);

//         return response()->json(['status' => 'Notification sent successfully!']);
//     }
// }
