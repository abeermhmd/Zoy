<?php

namespace App\Services;

use App\Models\{Product, ProductColor, ProductColorImage, ProductColorSize, ProductImage, ProductSimilar, ProductSize};
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductService
{
    use ImageTrait;

    public function createProduct($data): Product
    {
        return   DB::transaction(function () use ($data) {
            $newItem = new Product();
            $newItem->image = $this->storeImage($data['image'], 'products');
            $newItem->size_guide_image = $this->storeImage($data['size_guide_image'], 'products');
            $newItem->category_id = $data->category_id;
            $newItem->sku = $data->sku;
            $newItem->price = $data->price;
            $newItem->price_offer = $data->price_offer ?? 0;
            $newItem->weight = $data->weight;
            $newItem->most_selling = $data->has('most_selling') && $data->most_selling == 'on' ? 1 : 0;
            $newItem->new_arrival = $data->has('new_arrival') && $data->new_arrival == 'on' ? 1 : 0;

            if ($data->has('has_variants') && ($data->has('colors') || $data->has('sizes'))) {
                $newItem->has_variants = $data->has_variants == 'on' ? 1 : 0;
                $newItem->quantity = 0;
                $newItem->remaining_quantity = 0;
            } else {
                $newItem->quantity = $data->quantity;
                $newItem->remaining_quantity = $data->quantity;
            }

            storeTranslatedFields($newItem, ['name', 'description', 'key_words'], $data);

            if ($data->has('has_variants') && $data->has('colors') && $data->has('sizes')) {
                $newItem->type_variants = 1;
            } elseif ($data->has('has_variants') && $data->has('colors')) {
                $newItem->type_variants = 2;
            } elseif ($data->has('has_variants') && $data->has('sizes')) {
                $newItem->type_variants = 3;
            } else {
                $newItem->type_variants = 0;
            }
            $newItem->save();

            if ($data->has('filename')) {
                $imageNames = $this->storeImage($data['filename'], 'products');
                foreach ($imageNames as $imageName) {
                    ProductImage::create([
                        'product_id' => $newItem->id,
                        'image' => $imageName,
                    ]);
                }
            }

            if ($data->has('similar_products') && $data['similar_products'] != null) {
                foreach ($data['similar_products'] as $similar_product_id) {
                    ProductSimilar::create([
                        'product_id' => $newItem->id,
                        'similar_product_id' => $similar_product_id,
                    ]);
                }
            }

            $savedColorIds = $data->has('colors') ? $data['colors'] : [];
            $savedSizeIds = $data->has('sizes') ? $data['sizes'] : [];
            $baseSku = $newItem->sku;

            // Only colors
            if (!empty($savedColorIds) && empty($savedSizeIds)) {
                foreach ($savedColorIds as $color_id) {
                    $colorImages = $data['color_images'][$color_id] ?? [];

                    $productColorSize = ProductColorSize::create([
                        'product_id' => $newItem->id,
                        'color_id' => $color_id,
                        'size_id' => null,
                        'quantity' => 0,
                        'sku' => $baseSku . '-' . $color_id, // Add SKU with color_id
                    ]);

                    // Update SKU with productColorSize->id
                    $productColorSize->sku = $baseSku . '-' . $productColorSize->id;
                    $productColorSize->save();

                    // Save color images
                    foreach ($colorImages as $image) {
                        if ($image->isValid()) {
                            $imagePath = $this->storeImage($image, 'product_colors');
                            ProductColorImage::create([
                                'product_id' => $newItem->id,
                                'color_id' => $color_id,
                                'product_color_size_id' => $productColorSize->id,
                                'image' => $imagePath,
                            ]);
                        }
                    }
                }
            }

            // Only sizes
            if (empty($savedColorIds) && !empty($savedSizeIds)) {
                foreach ($savedSizeIds as $size_id) {
                    $productColorSize = ProductColorSize::create([
                        'product_id' => $newItem->id,
                        'color_id' => null,
                        'size_id' => $size_id,
                        'quantity' => 0,
                        'sku' => $baseSku . '-' . $size_id, // Add SKU with size_id
                    ]);

                    // Update SKU with productColorSize->id
                    $productColorSize->sku = $baseSku . '-' . $productColorSize->id;
                    $productColorSize->save();
                }
            }

            // Both colors and sizes
            if (!empty($savedColorIds) && !empty($savedSizeIds)) {
                foreach ($savedColorIds as $color_id) {
                    $colorImages = $data['color_images'][$color_id] ?? [];

                    foreach ($savedSizeIds as $size_id) {
                        $productColorSize = ProductColorSize::create([
                            'product_id' => $newItem->id,
                            'color_id' => $color_id,
                            'size_id' => $size_id,
                            'quantity' => 0,
                            'sku' => $baseSku . '-' . $color_id . '-' . $size_id, // Add SKU with color_id and size_id
                        ]);

                        // Update SKU with productColorSize->id
                        $productColorSize->sku = $baseSku . '-' . $productColorSize->id;
                        $productColorSize->save();

                        // Save color images
                        foreach ($colorImages as $image) {
                            if ($image->isValid()) {
                                $imagePath = $this->storeImage($image, 'product_colors');
                                ProductColorImage::create([
                                    'product_id' => $newItem->id,
                                    'color_id' => $color_id,
                                    'product_color_size_id' => $productColorSize->id,
                                    'image' => $imagePath,
                                ]);
                            }
                        }
                    }
                }
            }

            return $newItem;

        });
    }

    public function updateProduct(Product $item, $data)
    {
        DB::transaction(function () use ($data, $item) {
            $item->category_id = $data->category_id;
            $item->price = $data->price;
            $item->price_offer = $data->price_offer ?? 0;
            $item->weight = $data->weight;
            $item->most_selling = $data->has('most_selling') && $data->most_selling == 'on' ? 1 : 0;
            $item->new_arrival = $data->has('new_arrival') && $data->new_arrival == 'on' ? 1 : 0;

            if ($data->hasFile('image')) {
                $item->image = $this->storeImage($data['image'], 'products', $item->getRawOriginal('image') ?: null);
            }
            if ($data->hasFile('size_guide_image')) {
                $item->size_guide_image = $this->storeImage($data['size_guide_image'], 'products',
                    $item->getRawOriginal('size_guide_image') ?: null);
            }

            if ($data->has('has_variants') && ($data->has('colors') || $data->has('sizes'))) {
                $item->has_variants = $data->has_variants == 'on' ? 1 : 0;
            } else {
                $item->sku = $data->sku;
                $item->quantity = $data->quantity;
                $item->remaining_quantity = $data->quantity;
                $item->has_variants = 0;
            }

            storeTranslatedFields($item, ['name', 'description', 'key_words'], $data);

            if ($data->has('has_variants') && $data->has('colors') && $data->has('sizes')) {
                $item->type_variants = 1; // Colors and sizes
            } elseif ($data->has('has_variants') && $data->has('colors')) {
                $item->type_variants = 2; // Colors only
            } elseif ($data->has('has_variants') && $data->has('sizes')) {
                $item->type_variants = 3; // Sizes only
            } else {
                $item->type_variants = 0; // No variants
            }

            $item->save();

            // Handle product images
            if ($data->has('oldImages')) {
                $existingImageIds = $item->images->pluck('id')->toArray();
                $newImageIds = $data['oldImages'];
                $imagesToDelete = array_diff($existingImageIds, $newImageIds);
                ProductImage::whereIn('id', $imagesToDelete)->delete();
            }

            if ($data->has('filename')) {
                $imageNames = $this->storeImage($data['filename'], 'products');
                foreach ($imageNames as $imageName) {
                    ProductImage::create([
                        'product_id' => $item->id,
                        'image' => $imageName,
                    ]);
                }
            }

            // Handle similar products
            ProductSimilar::where('product_id', $item->id)->delete();
            if ($data->has('similar_products') && $data['similar_products'] != null) {
                foreach ($data['similar_products'] as $similar_product_id) {
                    ProductSimilar::create([
                        'product_id' => $item->id,
                        'similar_product_id' => $similar_product_id,
                    ]);
                }
            }

            // Handle variants (colors and sizes)
            $savedColorIds = $data->has('colors') ? $data['colors'] : [];
            $savedSizeIds = $data->has('sizes') ? $data['sizes'] : [];

            // Clean up existing variants if no longer applicable
            if (!$item->has_variants) {
                ProductColorSize::where('product_id', $item->id)->delete();
                ProductColorImage::where('product_id', $item->id)->delete();
            } else {
                // Delete removed images
                if ($data->has('deleted_images')) {
                    $deletedImages = ProductColorImage::whereIn('id', $data['deleted_images'])->pluck('image');
                    foreach ($deletedImages as $oneDeletedImage) {
                        $oldImageName = basename($oneDeletedImage);
                        $filePath = public_path("uploads/images/product_colors/$oldImageName");
                        if (File::exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    ProductColorImage::whereIn('id', $data['deleted_images'])->delete();
                }

                // Only colors
                if (!empty($savedColorIds) && empty($savedSizeIds)) {
                    $existingColorVariants = ProductColorSize::where('product_id', $item->id)
                        ->whereNotNull('color_id')
                        ->get();

                    foreach ($existingColorVariants as $variant) {
                        if (in_array($variant->color_id, $savedColorIds)) {
                            $variant->size_id = null;
                            $variant->save();
                        }
                    }

                    ProductColorSize::where('product_id', $item->id)
                        ->where(function($query) use ($savedColorIds) {
                            $query->whereNotIn('color_id', $savedColorIds)
                                ->orWhereNotNull('size_id');
                        })
                        ->delete();

                    foreach ($savedColorIds as $color_id) {
                        $colorImages = $data['color_images'][$color_id] ?? [];

                        $productColorSize = ProductColorSize::updateOrCreate(
                            [
                                'product_id' => $item->id,
                                'color_id' => $color_id,
                                'size_id' => null,
                            ],
                            ['quantity' => 0]
                        );

                        if ($productColorSize->wasRecentlyCreated) {
                            $productColorSize->sku = ($item->sku ?? 'DEFAULT') . '-' . $productColorSize->id;
                            $productColorSize->save();
                        }

                        foreach ($colorImages as $image) {
                            if ($image->isValid()) {
                                $imagePath = $this->storeImage($image, 'product_colors');
                                $existingImage = ProductColorImage::where([
                                    'product_id' => $item->id,
                                    'color_id' => $color_id,
                                    'image' => $imagePath
                                ])->first();

                                if (!$existingImage) {
                                    ProductColorImage::create([
                                        'product_id' => $item->id,
                                        'color_id' => $color_id,
                                        'product_color_size_id' => $productColorSize->id,
                                        'image' => $imagePath,
                                    ]);
                                }
                            }
                        }
                    }
                }

                // Only sizes
                if (empty($savedColorIds) && !empty($savedSizeIds)) {
                    ProductColorSize::where('product_id', $item->id)
                        ->where(function ($query) use ($savedSizeIds) {
                            $query->whereNotIn('size_id', $savedSizeIds)
                                ->orWhereNotNull('color_id');
                        })
                        ->delete();

                    foreach ($savedSizeIds as $size_id) {
                        $productColorSize = ProductColorSize::updateOrCreate(
                            [
                                'product_id' => $item->id,
                                'color_id' => null,
                                'size_id' => $size_id,
                            ],
                            ['quantity' => 0]
                        );
                        if ($productColorSize->wasRecentlyCreated) {
                            $productColorSize->sku = ($item->sku ?? 'DEFAULT') . '-' . $productColorSize->id;
                            $productColorSize->save();
                        }
                    }
                }

                // Mix sizes and colors
                if (!empty($savedColorIds) && !empty($savedSizeIds)) {
                    $existingCombinations = ProductColorSize::where('product_id', $item->id)->get();

                    foreach ($existingCombinations as $existing) {
                        if (!in_array($existing->color_id, $savedColorIds) || ($existing->size_id !== null && !in_array($existing->size_id, $savedSizeIds))) {
                            ProductColorImage::where([
                                'product_id' => $item->id,
                                'color_id' => $existing->color_id,
                                'product_color_size_id' => $existing->id
                            ])->delete();
                            $existing->delete();
                        }
                    }

                    foreach ($savedColorIds as $color_id) {
                        $colorImages = $data['color_images'][$color_id] ?? [];
                        $existingColorOnly = ProductColorSize::where([
                            'product_id' => $item->id,
                            'color_id' => $color_id,
                            'size_id' => null
                        ])->first();

                        foreach ($savedSizeIds as $size_id) {
                            if ($existingColorOnly) {
                                $productColorSize = $existingColorOnly->replicate();
                                $productColorSize->size_id = $size_id;
                                $productColorSize->quantity = 0;
                                $productColorSize->save();

                                ProductColorImage::where([
                                    'product_id' => $item->id,
                                    'color_id' => $color_id,
                                    'product_color_size_id' => $existingColorOnly->id
                                ])->update(['product_color_size_id' => $productColorSize->id]);
                            } else {
                                $productColorSize = ProductColorSize::updateOrCreate(
                                    [
                                        'product_id' => $item->id,
                                        'color_id' => $color_id,
                                        'size_id' => $size_id,
                                    ],
                                    ['quantity' => 0]
                                );
                                if ($productColorSize->wasRecentlyCreated) {
                                    $productColorSize->sku = ($item->sku ?? 'DEFAULT') . '-' . $productColorSize->id;
                                    $productColorSize->save();
                                }
                            }

                            if (!empty($colorImages)) {
                                foreach ($colorImages as $image) {
                                    if ($image->isValid()) {
                                        $imagePath = $this->storeImage($image, 'product_colors');
                                        $existingImage = ProductColorImage::where([
                                            'product_id' => $item->id,
                                            'color_id' => $color_id,
                                            'product_color_size_id' => $productColorSize->id,
                                            'image' => $imagePath
                                        ])->first();

                                        if (!$existingImage) {
                                            ProductColorImage::create([
                                                'product_id' => $item->id,
                                                'color_id' => $color_id,
                                                'product_color_size_id' => $productColorSize->id,
                                                'image' => $imagePath,
                                            ]);
                                        }
                                    }
                                }
                            }
                        }

                        if ($existingColorOnly) {
                            $existingColorOnly->delete();
                        }
                    }
                }

                $totalQuantity = ProductColorSize::where('product_id', $item->id)->sum('quantity');
                $item->update([
                    'quantity' => $totalQuantity,
                    'remaining_quantity' => $totalQuantity
                ]);
            }
        });
    }

    public function updateProductQuantities(Product $item, $data): void
    {
        DB::transaction(function () use ($data, $item) {
            $ids = $data['ids'] ?? [];
            $quantities = $data['quantities'] ?? [];
            $skus = $data['skus'] ?? [];

            if ($item->has_variants && !empty($ids) && !empty($quantities) && count($ids) === count($quantities)) {
                $totalQuantity = array_sum($quantities);

                switch ($item->type_variants) {
                    case 1: // Mix colors and sizes
                        foreach ($ids as $index => $colorSizeId) {
                            $quantity = $quantities[$index] ?? 0;
                            $sku = $skus[$index] ?? '';
                            ProductColorSize::where('id', $colorSizeId)
                                ->where('product_id', $item->id)
                                ->update([
                                    'quantity' => $quantity,
                                    'sku' => $sku
                                ]);
                        }
                        break;

                    case 2: // Colors only
                        foreach ($ids as $index => $colorId) {
                            $quantity = $quantities[$index] ?? 0;
                            $sku = $skus[$index] ?? '';
                            ProductColorSize::where('id', $colorId)
                                ->where('product_id', $item->id)
                                ->update([
                                    'quantity' => $quantity,
                                    'sku' => $sku
                                ]);
                        }
                        break;

                    case 3: // Sizes only
                        foreach ($ids as $index => $sizeId) {
                            $quantity = $quantities[$index] ?? 0;
                            $sku = $skus[$index] ?? '';
                            ProductColorSize::where('id', $sizeId)
                                ->where('product_id', $item->id)
                                ->update([
                                    'quantity' => $quantity,
                                    'sku' => $sku
                                ]);
                        }
                        break;
                }

                $item->update([
                    'quantity' => $totalQuantity,
                    'remaining_quantity' => $totalQuantity
                ]);
            }
        });
    }
}
