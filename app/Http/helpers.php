<?php

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

function storeTranslatedFields($model, $fieldNames, $data)
{
    if (is_null($model) || is_null($fieldNames) || is_null($data)) {
        return;
    }

    $locales = Language::all()->pluck('lang');

    collect($fieldNames)->map(function ($fieldName) use ($model, $locales, $data) {
        $locales->map(function ($locale) use ($fieldName, $model, $data) {
            $translatedField = $fieldName . '_' . $locale;

            if ($data->has($translatedField) && !is_null($data->get($translatedField))) {
                $model->translateOrNew($locale)->{$fieldName} = $data->get($translatedField);
            }
        });
    });
}

function can($permission)
{
    $userCheck = auth()->guard('admin')->check();
    $user = '';

    if ($userCheck == false) {
        return redirect('admin/login');
    } else {
        $user = auth()->guard('admin')->user();
    }

    if ($user->id == 1) {
        return true;
    }

    $minutes = 5;
    $permissions = Cache::remember('permissions_' . $user->id, $minutes, function () use ($user) {
        return explode(',', @$user->permission->permission);
    });

   $permissions = collect($permissions)->flatten()->toArray();

    return in_array($permission, $permissions);
}

function admin_assets($dir)
{
    return url('/admin_assets/assets/' . $dir);
}


function getLocal()
{
    return app()->getLocale();
}

function convertAr2En($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $num = range(0, 9);

    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

    return $englishNumbersOnly;
}

function sendSMS($mobile, $message)
{
    return true;
    try {
        $ch = curl_init();
        $data = "AppSid=g9X11HAoeK16Pb3I0mqaHZsOK_LIaR&Recipient=$mobile&Body=$message";
        curl_setopt($ch, CURLOPT_URL, "https://api.unifonic.com/rest/Messages/Send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    } catch (\Exception $ex) {
        return false;
    }
}

function random_number($digits)
{
    return str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
}

function updateFirebase($type = 'increment', $target = 'count_orders', $value = 1)
{
    $database = app('firebase.database');
    $currentValue = $database->getReference("orders/{$target}")->getSnapshot()->getValue();
    $newValue = 0;

    if (is_numeric($currentValue)) {
        switch ($type) {
            case 'increment':
                $newValue = $currentValue + $value;
                break;
            case 'decrement':
                $newValue = max(0, $currentValue - $value);
                break;
            case 'reset':
                $newValue = 0;
                break;
            case 'newValue':
                $newValue = $value;
                break;
            default:
                return;
        }

        $database->getReference("orders/{$target}")->set($newValue);
    } else {
        if ($type === 'newValue' || $type === 'reset') {
            $newValue = ($type === 'newValue') ? $value : 0;
            $database->getReference("orders/{$target}")->set($newValue);
        }
    }
}


function slugURL($title)
{
    $WrongChar = ['@', '؟', '.', '!', '?', '&', '%', '$', '#', '{', '}', '(', ')', '"', ':', '>', '<', '/', '|', '{', '^'];
    $titleNoChr = str_replace($WrongChar, '', $title);
    $titleSEO = str_replace(' ', '-', $titleNoChr);

    return $titleSEO;
}
