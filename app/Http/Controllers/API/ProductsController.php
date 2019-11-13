<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product as ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Category as CategoryResource;

class ProductsController extends BaseController
{
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * ProductsController constructor.
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $products = $this->productsRepository->all();
        return $this->sendResponse(ProductResource::collection($products), 'success');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productsRepository->find($id);
        if (!$product) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse(new ProductResource($product), 'success');
    }

    /**
     * @param ProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productsRepository->store($request);
        } catch (\RuntimeException $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse(new ProductResource($product), 'success');
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $product = $this->productsRepository->update($request, $product);
        } catch (\RuntimeException $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse(new ProductResource($product), 'success');
    }

    /**
     * @param Product $product
     * @return Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse([], 'success');
    }
}
