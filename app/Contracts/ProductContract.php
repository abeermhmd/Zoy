<?php

namespace App\Contracts;

use App\Models\Product;
use App\DataTransferObjects\Products\{ProductDataTransfer, ProductFilterDataTransfer};

interface ProductContract
{
    public function getProducts(?ProductFilterDataTransfer $filters = null);
    public function getProduct(string $id);
    public function createProduct(ProductDataTransfer $data);
    public function updateProduct(Product $product, ProductDataTransfer $data);
}
