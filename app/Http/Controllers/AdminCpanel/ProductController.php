<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Contracts\{CategoryContract, ColorContract, ProductContract, SizeContract};
use App\DataTransferObjects\Colors\ColorFilterDataTransfer;
use App\DataTransferObjects\Products\ProductFilterDataTransfer;
use App\DataTransferObjects\Sizes\SizeFilterDataTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductContract  $productContract,
        protected CategoryContract $categoryContract,
        protected ColorContract    $colorContract,
        protected SizeContract     $sizeContract,
        protected ProductService   $productService,
    )
    {
        $this->middleware(function ($request, $next) {
            if (!can('products')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }


    public function index(): View
    {
        $dtoFilter = ProductFilterDataTransfer::fromRequest(request());
        $items = $this->productContract->getProducts($dtoFilter);
        $categories = $this->categoryContract->GetProductCategoriesAction();

        return view('adminCpanel.products.home', compact('items', 'categories'));
    }


    public function create(): View
    {
        $item = new Product();
        $categories = $this->categoryContract->GetProductCategoriesAction();
        $colors = $this->getActiveColors();
        $sizes = $this->getActiveSizes();
        $similar_products = $this->getActiveSimilarProducts();

        return view('adminCpanel.products.create', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }


    public function store(ProductRequest $request): RedirectResponse
    {
        $product = $this->productService->createProduct($request);

        if ($product->has_variants) {
            return redirect()->route('admins.products.quantites', $product->id)
                ->with('status', __('cp.create'));
        }

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function show(int $id): View
    {
        $item = $this->productContract->getProduct($id, ['productColorSizes.images']);
        $categories = $this->categoryContract->GetProductCategoriesAction();
        $colors = $this->getActiveColors();
        $sizes = $this->getActiveSizes();
        $similar_products = $this->getActiveSimilarProducts($id);

        return view('adminCpanel.products.show', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }


    public function edit(int $id): View
    {
        $item = $this->productContract->getProduct($id, ['productColorSizes.images']);
        $categories = $this->categoryContract->GetProductCategoriesAction();
        $colors = $this->getActiveColors();
        $sizes = $this->getActiveSizes();
        $similar_products = $this->getActiveSimilarProducts($id);

        return view('adminCpanel.products.edit', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }


    public function update(ProductRequest $request, int $id): RedirectResponse
    {
        $item = $this->productContract->getProduct($id);
        $this->productService->updateProduct($item, $request);

        return redirect()->back()->with('status', __('cp.update'));
    }


    public function quantites(int $id): View
    {
        $item = $this->productContract->getProduct($id, ['productColorSizes'], true);

        return view('adminCpanel.products.quantites', compact('item'));
    }


    public function updateQuantites(ProductRequest $request, int $id): RedirectResponse
    {
        $item = $this->productContract->getProduct($id, [], true);
        $this->productService->updateProductQuantities($item, $request);

        return redirect()->back()->with('status', __('cp.update'));
    }


    private function getActiveColors()
    {
        $dtoColorFilter = ColorFilterDataTransfer::fromRequest([
            'isPaginate' => false,
            'status' => 'active'
        ]);

        return $this->colorContract->getColors($dtoColorFilter);
    }


    private function getActiveSizes()
    {
        $dtoSizeFilter = SizeFilterDataTransfer::fromRequest([
            'isPaginate' => false,
            'status' => 'active'
        ]);

        return $this->sizeContract->getSizes($dtoSizeFilter);
    }


    private function getActiveSimilarProducts(int $excludeId = null)
    {
        $filterParams = [
            'isPaginate' => false,
            'status' => 'active'
        ];

        if ($excludeId) {
            $filterParams['idNotEqual'] = $excludeId;
        }

        $dtoProductFilter = ProductFilterDataTransfer::fromRequest($filterParams);

        return $this->productContract->getProducts($dtoProductFilter);
    }
}
