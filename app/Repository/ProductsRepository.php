<?php

namespace App\Repository;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductsRepository
{
    /**
     * @return Product[]|Collection
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): ?Product
    {
        return Product::find($id);
    }

    /**
     * @param ProductRequest $productRequest
     * @return Product
     */
    public function store(ProductRequest $productRequest): Product
    {
        $category = $this->extractCategory($productRequest);

        $product = new Product();
        $product->name = $productRequest->input('name');
        $product->details = $productRequest->input('details');
        $product->image = $this->storeImage($productRequest);

        $category->products()->save($product);

        return $product;
    }

    /**
     * @param ProductRequest $productRequest
     * @param Product $product
     * @return Product
     */
    public function update(UpdateProductRequest $productRequest, Product $product): Product
    {
        if ($productRequest->input('category_id')) {
            $category = $this->extractCategory($productRequest);
            if ($category) {
                $product->category_id = $category->id;
            }
        }

        if ($productRequest->input('name')) {
            $product->name = $productRequest->input('name');
        }

        if ($productRequest->input('details')) {
            $product->details = $productRequest->input('details');
        }

        if ($productRequest->hasFile('image')) {
            $product->image = $this->storeImage($productRequest);
        }

        $product->save();

        return $product;
    }

    /**
     * @param ProductRequest|UpdateProductRequest $productRequest
     * @return Category
     */
    private function extractCategory($productRequest): Category
    {
        $category = Category::find($productRequest->input('category_id'));
        if (!$category) {
            throw new \RuntimeException('Category not found');
        }
        return $category;
    }

    /**
     * @param ProductRequest $productRequest
     * @return string|null File Name
     */
    public function storeImage(ProductRequest $productRequest): ?string
    {
        $image = $productRequest->file('image');
        if ($image instanceof UploadedFile) {
            return $image->store('uploads', 'public');
        }
        return null;
    }
}
