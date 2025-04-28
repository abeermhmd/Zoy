<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Language, Order, Setting, OrderProduct, Product, Country};

class ReportController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::first();
        view()->share(['locales' => $this->locales, 'setting' => $this->settings,]);
        $this->middleware(function ($request, $next) {
            if (!can('reports')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $totalSales = Order::query()->filter()->orderBy('id', 'desc')->where('payment_status', 1)->paginate($this->settings->dashboard_paginate);

        $topProducts = OrderProduct::selectRaw('product_id, SUM(quantity) as quantity_sold')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 1)
            ->where(function ($query) {
                $query->whereIn('orders.id', Order::query()->filter()->pluck('id'));
            })
            ->groupBy('product_id')
            ->orderByDesc('quantity_sold')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->product = Product::select('id')
                    ->with(['translations' => function ($query) { ///select only id and name because other data not required
                        $query->where('locale', app()->getLocale());
                    }])
                    ->find($item->product_id);
                if ($item->product && $item->product->translations->isNotEmpty()) {
                    $item->product->name = $item->product->translations->first()->name;
                }

                return $item;
            });

        $categorySales = OrderProduct::selectRaw('product_id, SUM(quantity) as quantity_sold')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 1)
            ->where(function ($query) {
                $query->whereIn('orders.id', Order::query()->filter()->pluck('id'));
            })
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                $item->product = Product::find($item->product_id);
                $item->category_name = $item->product->category->name;
                $item->total_amount = $item->quantity_sold * $item->product->price;
                return $item;
            })
            ->groupBy('category_name');

        $countrySales = Order::where('payment_status', 1)
            ->when(request()->has('start_date') || request()->has('end_date'), function($query) {
                $query->whereRaw('date(orders.created_at) >= ?', [request()->start_date ?? date('Y-m-d')])
                    ->whereRaw('date(orders.created_at) <= ?', [request()->end_date ?? date('Y-m-d')]);
            })
            ->with('address.country')
            ->selectRaw('
        COALESCE(orders.country_id, user_addresses.country_id) as country_id,
        COUNT(orders.id) as orders_count,
        SUM(orders.total) as total_amount
    ')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id') // استخدام user_addresses بدلاً من addresses
            ->groupBy('country_id')
            ->get()
            ->map(function ($item) {
                $item->country = $item->country_id ? ($item->country->name ?? $item->country_id) : ($item->address->country->name ?? 'Unknown');
                return $item;
            });
        return view('adminCpanel.reports.home', compact('totalSales', 'topProducts', 'categorySales', 'countrySales'));
    }
    public function salesByCountry(Request $request)
    {
        // Query for top products by country
        $topProductsByCountry = OrderProduct::selectRaw('order_products.product_id, SUM(order_products.quantity) as quantity_sold, COALESCE(user_addresses.country_id, orders.country_id) as effective_country_id')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('orders.payment_status', 1)
            ->where(function ($query) {
                $query->whereIn('orders.id', Order::query()->filter()->pluck('id'));
            })
            ->groupBy('effective_country_id', 'order_products.product_id')
            ->orderByDesc('quantity_sold')
            ->get();

        // Preload countries with translations
        $countryIds = $topProductsByCountry->pluck('effective_country_id')->unique();
        $countries = Country::select('id')
            ->with(['translations' => function ($query) {
                $query->select('country_id', 'name')
                    ->where('locale', app()->getLocale());
            }])
            ->whereIn('id', $countryIds)
            ->get()
            ->keyBy('id')
            ->map(function ($country) {
                return $country->translations->isNotEmpty() ? $country->translations->first()->name : 'N/A';
            });

        // Preload products with translations
        $productIds = $topProductsByCountry->pluck('product_id')->unique();
        $products = Product::select('id')
            ->with(['translations' => function ($query) {
                $query->select('product_id', 'name')
                    ->where('locale', app()->getLocale());
            }])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id')
            ->map(function ($product) {
                return $product->translations->isNotEmpty() ? $product->translations->first()->name : 'N/A';
            });

        // Group and format data
        $topProductsByCountry = $topProductsByCountry
            ->groupBy('effective_country_id')
            ->map(function ($countryProducts, $countryId) use ($countries, $products) {
                $countryName = $countries[$countryId] ?? 'N/A';
                return [
                    'country_id' => $countryId,
                    'country_name' => $countryName,
                    'products' => $countryProducts
                        ->take(10) // Limit to top 10 products
                        ->map(function ($item) use ($products) {
                            return [
                                'product_id' => $item->product_id,
                                'product_title' => $products[$item->product_id] ?? 'N/A',
                                'quantity_sold' => $item->quantity_sold,
                            ];
                        })
                        ->values()
                ];
            })
            ->values();

        return view('adminCpanel.reports.salesByCountry', compact('topProductsByCountry'));
    }
    public function usersOrdersReports()
    {
        $items = Order::query()->filter()->whereNotNull('user_id')->orderBy('id')->where('payment_status' , 1)->paginate( $this->settings->paginate);
        return view('adminCpanel.reports.usersOrdersReports', compact('items'));
    }
}
