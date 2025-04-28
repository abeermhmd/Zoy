<?php

namespace App\Services;

use App\Models\EmailText;
use Illuminate\Support\Facades\DB;

class EmailTextService
{
    public function updateEmailText(EmailText $item, $data): void
    {
        DB::transaction(function () use ($item, $data) {
            storeTranslatedFields($item, ['subject', 'content'], $data);
            $item->save();
        });
    }
}
