<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Models\{Cart,
    Favorite,
    Order,
    Product,
    ProductColorImage,
    ProductColorSize,
    ProductImage,
    ProductSimilar,
    User,
    Category,
    Contact
};
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $countUsers = User::query()->count();
        $countGuest = Order::where('payment_status', 1)->where('user_id', null)->whereNotNull('user_key')->distinct('user_key')->count();
        $countFailedOrders = Order::whereIn('payment_status', [0, 2])->count();
        $totalOrderToday = Order::where('created_at', 'LIKE', '%' . date('Y-m-d') . '%')->where('payment_status', 1)->count();
        $placedOrder = Order::where('status', 0)->where('payment_status', 1)->count();
        $onTheWayOrderCount = Order::where('status', 1)->where('payment_status', 1)->count();
        $deliveredOrder = Order::where('status', 3)->where('payment_status', 1)->count();
        $canceledOrder = Order::where('status', 4)->where('payment_status', 1)->count();
        $totalAmountOrder = Order::where('status', '!=', 1)->where('payment_status', 1)->sum('sub_total');
        $countProducts = Product::count();
        $countCategories = Category::query()->whereNull('parent_id')->count();
        $countSubCategories = Category::query()->whereNotNull('parent_id')->count();
        return view('adminCpanel.home.dashboard', compact('countUsers', 'placedOrder', 'onTheWayOrderCount', 'countGuest'
            , 'deliveredOrder', 'canceledOrder', 'countCategories', 'totalAmountOrder', 'totalOrderToday', 'countProducts', 'countSubCategories', 'countFailedOrders'));
    }


    public function changeStatus($model, Request $request)
    {
        $role = "";
        if ($model == "admins") $role = 'App\Models\Admin';
        if ($model == "users") $role = 'App\Models\User';
        if ($model == "pages") $role = 'App\Models\Page';
        if ($model == "banners") $role = 'App\Models\Banner';
        if ($model == "categories") $role = 'App\Models\Category';
        if ($model == "subCategories") $role = 'App\Models\Category';
        if ($model == "contact") $role = 'App\Models\Contact';
        if ($model == "permissions") $role = 'App\Models\Permission';
        if ($model == "promoCodes") $role = 'App\Models\PromoCode';
        if ($model == "colors") $role = 'App\Models\Color';
        if ($model == "sizes") $role = 'App\Models\Size';
        if ($model == "faqs") $role = 'App\Models\Faq';
        if ($model == "subscribers") $role = 'App\Models\Subscriber';
        if ($model == "newsletters") $role = 'App\Models\Newsletter';
        if ($model == "products") $role = 'App\Models\Product';
        if ($model == "emailTexts") $role = 'App\Models\EmailText';
        if ($model == "manual_emails") $role = 'App\Models\ManualEmail';

        if ($role != "") {
            if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->each(function ($item) use ($model) {
                    if (isset($item->image) && $item->image) {
                        $imageName = basename($item->image);
                        if ($model == 'banners') {
                            $folder = 'mainImages';
                        } else {
                            $folder = strtolower(string: $model);
                        }
                        $this->deleteOldImage($folder, $imageName);
                    }
                    if (isset($item->size_guide_image) && $item->size_guide_image) {
                        $imageName = basename($item->size_guide_image);
                        $this->deleteOldImage('products', $imageName);
                    }
                });
                if ($model == 'products') {

                    Favorite::query()->whereIn('product_id', $request->IDsArray)->delete();
                    Cart::query()->whereIn('product_id', $request->IDsArray)->delete();
                    $produtImages = ProductImage::query()->whereIn('product_id', $request->IDsArray)->pluck('image')->toArray();
                    if ($produtImages) {
                        foreach ($produtImages as $produtImage) {
                            $this->deleteOldImage('products', basename($produtImage));
                        }
                    }

                    ProductImage::query()->whereIn('product_id', $request->IDsArray)->delete();
                    ProductColorSize::query()->whereIn('product_id', $request->IDsArray)->delete();
                    $produtColorImages = ProductColorImage::query()->whereIn('product_id', $request->IDsArray)->pluck('image')->toArray();
                    if ($produtColorImages) {
                        foreach ($produtColorImages as $produtColorImage) {
                            $this->deleteOldImage('product_colors', basename($produtColorImage));
                        }
                    }
                    ProductColorImage::query()->whereIn('product_id', $request->IDsArray)->delete();
                    ProductSimilar::query()->whereIn('product_id', $request->IDsArray)->delete();
                }
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            } else {
                if ($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }
            return response()->json([
                'status' => true,
                'message' => __('cp.success_message'),
                'action' => $request->action,
            ]);

        }
        return false;
    }

    public function sendOrderToServer($model, Request $request)
    {
        $role = "";
        if ($model == "admins") $role = 'App\Models\Admin';
        if ($model == "users") $role = 'App\Models\User';

        if ($role != "") {
            if (!empty($request->order)) {
                foreach ($request->order as $one) {
                    $role::query()->where('id', $one['id'])->update(['ordered' => $one['position']]);
                }

                return '{"status":"success"}';
            }
            return '{"status":"fail"}';

        }
        return false;
    }


}
