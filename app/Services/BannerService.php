<?php

namespace App\Services;
use App\Models\Banner;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class BannerService
{
    use ImageTrait;
    public function createBanner($data): void
    {
        DB::transaction(function () use ($data) {
            $banner = new Banner();
            if ($data->type == 1 && $data->hasFile('image')) {
                $banner->image = $this->storeImage($data->file('image'), 'mainImages');
            }elseif($data->type == 2 && $data->hasFile('url')){
                $banner->image = $this->storeImage($data->file('url'), 'mainImages' , null,null,null, 2);
            }
            $banner->type = $data['type'];
            $banner->type_link = $data['type_link'];
            if ($data['type_link'] == 2) {
                $banner->linked_id = $data['product_id'];
            } elseif ($data['type_link'] == 3) {
                $banner->linked_id = $data['category_id'];
            } elseif ($data['type_link'] == 4) {
                $banner->linked_id = $data['sub_category_id'];
            } else {
                $banner->linked_id = null;
            }
            $banner->save();
        });
    }

    public function updateBanner(Banner $banner, $data): void
    {
        DB::transaction(function () use ($data , $banner) {
            if ($data->type == 1 && $data->hasFile('image')) {
                $banner->image = $this->storeImage($data['image'], 'mainImages', $banner->getRawOriginal('image') ? $banner->getRawOriginal('image') : null);
            }elseif($data->type == 2 && $data->hasFile('url')){
                $banner->image = $this->storeImage($data->file('url'), 'mainImages' , $banner->getRawOriginal('image') ?$banner->getRawOriginal('image') : null,null,null, 2);
            }
            $banner->type = $data['type'];
            $banner->type_link = $data['type_link'];
            if ($data['type_link'] == 2) {
                $banner->linked_id = $data['product_id'];
            } elseif ($data['type_link'] == 3) {
                $banner->linked_id = $data['category_id'];
            } elseif ($data['type_link'] == 4) {
                $banner->linked_id = $data['sub_category_id'];
            } else {
                $banner->linked_id = null;
            }
            $banner->save();
        });
    }
    public function bannerAdUpdate($data): void
    {
        DB::transaction(function () use ($data ) {
            $settings = Setting::first();
            if ($data->hasFile('banner_ad_image')) {
                $settings->banner_ad_image = $this->storeImage($data['banner_ad_image'], 'settings',
                    $settings->getRawOriginal('banner_ad_image') ?  $settings->getRawOriginal('banner_ad_image') : null);
            }
            $settings->type_link = $data['type_link'];
            if ($data['type_link'] == 2) {
                $settings->linked_id = $data['product_id'];
            } elseif ($data['type_link'] == 3) {
                $settings->linked_id = $data['category_id'];
            } elseif ($data['type_link'] == 4) {
                $settings->linked_id = $data['sub_category_id'];
            } else {
                $settings->linked_id = null;
            }
            $settings->save();
        });
    }
    public function adPopUpUpdate($data): void
    {
        DB::transaction(function () use ($data ) {
            $settings = Setting::first();
            if ($data->hasFile('ad_popUp_image')) {
                $settings->ad_popUp_image = $this->storeImage($data['ad_popUp_image'], 'settings',
                    $settings->getRawOriginal('ad_popUp_image') ?  $settings->getRawOriginal('ad_popUp_image') : null);
            }
            $settings->type_link_pop = $data['type_link'];
            if ($data['type_link'] == 2) {
                $settings->linked_id_pop = $data['product_id'];
            } elseif ($data['type_link'] == 3) {
                $settings->linked_id_pop = $data['category_id'];
            } elseif ($data['type_link'] == 4) {
                $settings->linked_id_pop = $data['sub_category_id'];
            } else {
                $settings->linked_id_pop = null;
            }
            $settings->save();
        });
    }
}
