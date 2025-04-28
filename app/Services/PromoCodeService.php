<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Models\PromoCodeCountry;
use Illuminate\Support\Facades\DB;

class PromoCodeService {
    public function createPromoCode($data): void
    {
        DB::transaction(function () use ($data) {
           $item = new PromoCode();
           $item->code = $data->code;
           $item->maximum_usage = $data->maximum_usage;
           $item->number_remaining_uses = $data->maximum_usage;
           $item->discount_percentage = $data->discount_percentage;
           $item->start_date = $data->start_date;
           $item->end_date = $data->end_date;
            if (in_array("0", $data->input("countries"))) {
                    $item->all_countries = 1; //for all countries
            } else {
                    $item->all_countries = 0; //for selected multi countries
            }
           $item->save();

           if (!in_array("0", $data->input("countries"))) {
            foreach($data->countries as $oneOption){
                $newSubCoupon = new PromoCodeCountry();
                $newSubCoupon->promo_code_id = $item->id;
                $newSubCoupon->country_id = $oneOption;
                $newSubCoupon->save();
            }
           }
        });
    }
    public function updatePromoCode(PromoCode $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
          $item->code = $data->code;
          $item->maximum_usage = $data->maximum_usage;
          $item->number_remaining_uses = $data->maximum_usage;
          $item->discount_percentage = $data->discount_percentage;
          $item->start_date = $data->start_date;
          $item->end_date = $data->end_date;
            if (in_array("0", $data->input("countries"))) {
                $item->all_countries = 1; //for all countries
            } else {
                $item->all_countries = 0; //for selected multi countries
            }
          $item->save();

        PromoCodeCountry::where('promo_code_id' , $item->id)->forceDelete();

        if (!in_array("0", $data->input("countries"))) {
            foreach($data->countries as $oneOption){
            $newSubCoupon = new PromoCodeCountry();
            $newSubCoupon->promo_code_id = $item->id;
            $newSubCoupon->country_id = $oneOption;
            $newSubCoupon->save();
            }
        }
        });
    }

}
