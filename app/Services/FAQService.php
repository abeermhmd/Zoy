<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FAQService {
    public function createFaqs($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Faq();
            storeTranslatedFields($newItem , ['question' ,'answer'] , $data);
            $newItem->save();
        });
    }
    public function updateFaqs(Faq $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            storeTranslatedFields($item , ['question' ,'answer'] , $data );
            $item->save();
        });
    }

}
