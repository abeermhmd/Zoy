<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Models\{Country, Order, OrderProduct, Product, Subscriber, User};
use App\Services\Exports\ExportExcelService;
use Illuminate\Http\Request;

class ExportExcelController extends Controller
{
    public function exportProducts()
    {
        $columns = [
            'id', 'name', 'category.name', 'weight', 'remaining_quantity', 'sold_quantity',
            'price', 'price_offer', 'status', 'created_at'
        ];
        $titles = [
            __("cp.id"), __("cp.name"), __("cp.category"), __('cp.weight') . '/' . __('cp.KG'),
            __("cp.remaining_stock_quantity"), __("cp.sold_stock_quantity"),
            __('cp.price') . '/' . __('cp.KD'), __('cp.offer_price') . '/' . __('cp.KD'),
            __("cp.status"), __("cp.created")
        ];
        $model = Product::class;
        $export = new ExportExcelService($model, $columns, $titles);
        return $export->download('Products_Sheet.xlsx');
    }

    public function exportUsers()
    {
        $columns = [
            'id', 'name', 'email', 'mobile', 'date_of_birth', 'order_count', 'status', 'created_at'
        ];
        $titles = [
            __("cp.id"), __("cp.name"), __("cp.email"), __('cp.mobile'),
            __("cp.date_of_birth"), __("cp.req_count"), __("cp.status"), __("cp.created")
        ];
        $model = User::class;
        $export = new ExportExcelService($model, $columns, $titles);
        return $export->download('Users_Sheet.xlsx');
    }

    public function exportSubscribers()
    {
        $columns = ['created_at', 'email', 'status'];
        $titles = [
            __("cp.Subscription_date"), __("cp.email"), __("cp.status")
        ];
        $model = Subscriber::class;
        $export = new ExportExcelService($model, $columns, $titles);
        return $export->download('Subscribers_Sheet.xlsx');
    }

    public function exportOrders()
    {
        $columns = [
            'id', 'user_name', 'user_email', 'user_mobile', 'total', 'delivery_fees', 'status_name', 'created_at_order'
        ];
        $titles = [
            __("cp.order_id"), __("cp.customer"), __("cp.email"), __("cp.mobile"), __("cp.total") . ' / ' . __("cp.KD"),
            __("cp.delivery_cost") . ' / ' . __("cp.KD"), __("cp.ReqStatus"), __("cp.order_date")
        ];
        $model = Order::class;
        $export = new ExportExcelService($model, $columns, $titles);
        return $export->download('Orders_Sheet.xlsx');
    }
    public function exportUsersOrdersReports()
    {
        $columns = [
            'user_id',
            'id',
            'shipping_order_number',
            'InvoiceReference',
            'created_at_order',
            'user_name',
            'user_email',
            'user_mobile',
            'products_details',
            'address_details',
            'shipping_country_name',
            'payment_name',
            'total',
            'sub_total',
            'discount',
            'delivery_fees',
        ];
        $titles = [
            __("cp.user_id"),
            __("cp.order_id"),
            __("cp.Shipping Order Number"),
            __("cp.Order Invoice Reference"),
            __("cp.order_date"),
            __("cp.customer"),
            __("cp.email"),
            __("cp.mobile"),
            __("cp.products details"),
            __("cp.address"),
            __("cp.Shipping country name"),
            __("cp.payment_method"),
            __("cp.total") . ' / ' . __("cp.KD"),
            __("cp.sub_total") . ' / ' . __("cp.KD"),
            __("cp.Discount") . ' / ' . __("cp.KD"),
            __("cp.delivery_cost") . ' / ' . __("cp.KD"),
        ];

        $query = Order::filter()->with(['user', 'products.product', 'products.size', 'products.color', 'address.country', 'address.city'])
            ->whereNotNull('user_id')
            ->where('payment_status', 1)
            ->orderBy('id');

        $orders = $query->get();

        $data = [];
        foreach ($orders as $one) {
            $productsDetails = '';
            foreach ($one->products as $oneProduct) {
                $productsDetails .= $oneProduct->product->name ?? '';

                if ($oneProduct->size_id != '') {
                    $productsDetails .= ' / ' . __('website.Size') . ' : ' . ($oneProduct->size->name ?? '');
                }

                if ($oneProduct->color_id != '') {
                    $productsDetails .= ' / ' . __('website.Color') . ' : ' . ($oneProduct->color->name ?? '');
                }

                $productsDetails .= ' / ' . __('website.Qty') . ' : ' . ($oneProduct->quantity ?? '');
                $productsDetails .= "\n";
            }

            $addressDetails = '';
            if ($one->address) {
                $addressDetails = ($one->address->country->name ?? '') . ', ' .
                    ($one->address->city->name ?? '') . ', ' .
                    ($one->address->address_line_one ?? '');

                if (!empty($one->address_line_two)) {
                    $addressDetails .= ', ' . $one->address_line_two;
                }

                if (!empty($one->extra_directions)) {
                    $addressDetails .= ', ' . $one->extra_directions;
                }

                if (!empty($one->postal_code)) {
                    $addressDetails .= ', ' . $one->postal_code;
                }
            }

            $data[] = [
                'user_id' => $one->user_id,
                'id' => $one->id,
                'shipping_order_number' => $one->id, // Assuming shipping order number is the same as order ID
                'InvoiceReference' => $one->InvoiceReference,
                'created_at_order' => $one->created_at ? $one->created_at->format('d/m/y') . ' | ' . $one->created_at->format('h:i A') : '',
                'user_name' => $one->user->name ?? '',
                'user_email' => $one->user->email ?? '',
                'user_mobile' => $one->user->mobile ?? '',
                'products_details' => $productsDetails,
                'address_details' => $addressDetails,
                'shipping_country_name' => $one->address->country->name ?? '',
                'payment_name' => $one->payment_name,
                'total' => number_format($one->total, 3),
                'sub_total' => number_format($one->sub_total, 3),
                'discount' => number_format($one->discount, 3),
                'delivery_fees' => number_format($one->delivery_fees, 3),
            ];
        }

        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Sales_By_Customer_Report.xlsx');
    }

    public function exportReports(Request $request)
    {
        $tab = $request->query('tab', 'sales'); // Default to 'sales' if no tab specified

        switch ($tab) {
            case 'sales':
                return $this->exportTotalSales($request);
            case 'top-products':
                return $this->exportTopProducts($request);
            case 'category':
                return $this->exportCategorySales($request);
            case 'country':
                return $this->exportCountrySales($request);
            case 'sales-product-by-country':
                return $this->exportSalesProdutByCountry($request);

            default:
                return $this->exportTotalSales($request);
        }
    }

    private function exportTotalSales(Request $request)
    {
        $columns = ['id', 'country', 'total'];
        $titles = [
            __('cp.order_id'),
            __('cp.country'),
            __('cp.total_amount') . ' (' . __('cp.KD') . ')'
        ];

        $data = Order::query()
            ->filter()
            ->orderBy('id', 'desc')
            ->where('payment_status', 1)
            ->with('address.country')
            ->get()
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'country' => $sale->country_id ? $sale->country->name : $sale->address->country->name,
                    'total' => number_format($sale->total, 3)
                ];
            })->toArray();

        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Total_Sales_Report.xlsx');
    }

    private function exportTopProducts(Request $request)
    {
        $columns = ['product_id', 'product_name', 'quantity_sold'];
        $titles = [
            __('cp.product_id'),
            __('cp.product_title'),
            __('cp.quantity_sold')
        ];

        $data = OrderProduct::selectRaw('product_id, SUM(quantity) as quantity_sold')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 1)
            ->whereIn('orders.id', Order::query()->filter()->pluck('id'))
            ->groupBy('product_id')
            ->orderByDesc('quantity_sold')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $product = Product::select('id')
                    ->with(['translations' => function ($query) {
                        $query->where('locale', app()->getLocale());
                    }])
                    ->find($item->product_id);
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $product && $product->translations->isNotEmpty() ? $product->translations->first()->name : 'N/A',
                    'quantity_sold' => $item->quantity_sold
                ];
            })->toArray();

        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Top_Products_Report.xlsx');
    }

    private function exportCategorySales(Request $request)
    {
        $columns = ['category_name', 'quantity_sold', 'total_amount'];
        $titles = [
            __('cp.category'),
            __('cp.quantity_sold'),
            __('cp.total_amount') . ' (' . __('cp.KD') . ')'
        ];

        $data = OrderProduct::selectRaw('product_id, SUM(quantity) as quantity_sold')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 1)
            ->whereIn('orders.id', Order::query()->filter()->pluck('id'))
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'category_name' => $product->category->name ?? 'N/A',
                    'quantity_sold' => $item->quantity_sold,
                    'total_amount' => number_format($item->quantity_sold * $product->price, 3)
                ];
            })->toArray();

        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Category_Sales_Report.xlsx');
    }

    private function exportCountrySales(Request $request)
    {
        $columns = ['country', 'orders_count', 'total_amount'];
        $titles = [
            __('cp.country'),
            __('cp.orders_count'),
            __('cp.total_amount') . ' (' . __('cp.KD') . ')'
        ];

        // Get date filters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build the query
        $query = Order::where('payment_status', 1)
            ->with('address.country')
            ->selectRaw('
            COALESCE(orders.country_id, user_addresses.country_id) as country_id,
            COUNT(orders.id) as orders_count,
            SUM(orders.total) as total_amount
        ')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->groupBy('country_id');

        // Apply date filters conditionally
        if ($startDate && $endDate) {
            $query->whereRaw('date(orders.created_at) >= ?', [$startDate])
                ->whereRaw('date(orders.created_at) <= ?', [$endDate]);
        } elseif ($startDate) {
            $query->whereRaw('date(orders.created_at) >= ?', [$startDate]);
        } elseif ($endDate) {
            $query->whereRaw('date(orders.created_at) <= ?', [$endDate]);
        }

        // Fetch and format data
        $data = $query->get()->map(function ($item) {
            return [
                'country' => $item->country_id ? ($item->country->name ?? $item->country_id) : ($item->address->country->name ?? 'Unknown'),
                'orders_count' => $item->orders_count,
                'total_amount' => number_format($item->total_amount, 3)
            ];
        })->toArray();

        // Handle empty data
        if (empty($data)) {
            $data = [['message' => __('cp.no_data')]];
        }

        // Export to Excel
        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Country_Sales_Report.xlsx');
    }


    private function exportSalesProdutByCountry(Request $request)
    {
        $columns = ['country', 'product_id', 'product_title', 'quantity_sold'];
        $titles = [
            __('cp.country'),
            __('cp.product_id'),
            __('cp.product_title'),
            __('cp.quantity_sold')
        ];

        // Get date filters and country_id
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $countryId = $request->input('country_id');

        // Build the query
        $query = OrderProduct::selectRaw('
        COALESCE(orders.country_id, user_addresses.country_id) as effective_country_id,
        order_products.product_id,
        SUM(order_products.quantity) as quantity_sold
    ')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('orders.payment_status', 1)
            ->groupBy('effective_country_id', 'order_products.product_id')
            ->orderBy('effective_country_id')
            ->orderByDesc('quantity_sold');

        // Apply date filters conditionally
        if ($startDate && $endDate) {
            $query->whereRaw('date(orders.created_at) >= ?', [$startDate])
                ->whereRaw('date(orders.created_at) <= ?', [$endDate]);
        } elseif ($startDate) {
            $query->whereRaw('date(orders.created_at) >= ?', [$startDate]);
        } elseif ($endDate) {
            $query->whereRaw('date(orders.created_at) <= ?', [$endDate]);
        }

        // Apply country filter if provided
        if ($countryId) {
            $query->where(function ($q) use ($countryId) {
                $q->where('orders.country_id', $countryId)
                    ->orWhere('user_addresses.country_id', $countryId);
            });
        }

        // Preload countries with translations
        $countryResults = $query->get();
        $countryIds = $countryResults->pluck('effective_country_id')->unique();

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
        $productIds = $countryResults->pluck('product_id')->unique();
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

        // Format data for export
        $data = $countryResults
            ->map(function ($item) use ($countries, $products) {
                return [
                    'country' => $countries[$item->effective_country_id] ?? 'Unknown',
                    'product_id' => $item->product_id,
                    'product_title' => $products[$item->product_id] ?? 'N/A',
                    'quantity_sold' => $item->quantity_sold
                ];
            })->toArray();

        $export = new ExportExcelService(null, $columns, $titles, $data);
        return $export->download('Sales_Product_By_Country_Report.xlsx');
    }
}
