<?php

namespace App\Services;
use App\Models\Page;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class PageService
{
    use ImageTrait;

    public function createPage($data)
    {
        DB::transaction(function () use ($data) {
            $item = new Page();
            storeTranslatedFields($item , ['description'] , $data);
            if ($data->hasFile('image')) {
                $item->image = $this->storeImage($data->file('image'), 'pages');
            }
            $item->save();
        });
    }

    public function updatePage(Page $item, $data)
    {
        DB::transaction(function () use ($item , $data) {
            storeTranslatedFields($item , ['name','description'] , $data);
            if ($data->hasFile('image')) {
                $item->image = $this->storeImage($data['image'], 'pages', $item->getRawOriginal('image') ? $item->getRawOriginal('image') : null);
            }
            $item->save();
        });
    }
}
