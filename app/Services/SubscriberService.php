<?php

namespace App\Services;

use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class SubscriberService {
    public function createSubscriber($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Subscriber();
            $newItem->email = $data->email;
            $newItem->save();
        });
    }

    public function updateSubscriber(Subscriber $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            $item->email = $data->email;
            $item->save();
        });
    }

}
