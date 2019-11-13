<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Product as ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Category as CategoryResource;

class CategoriesController extends BaseController
{
    /**
     * @var CategoriesRepository
     */
    private $categoriesRepository;

    /**
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $categories = $this->categoriesRepository->findRootCategories();
        return $this->sendResponse(CategoryResource::collection($categories), 'success');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $categories = $this->categoriesRepository->findChildren($id);
        return $this->sendResponse(CategoryResource::collection($categories), 'success');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function productsByCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return  $this->sendError('Category not found');
        }

        $products = $this->categoriesRepository->getProductsByCategory($category);
        return $this->sendResponse(ProductResource::collection($products), 'success');
    }

    /**
     * @param CategoryRequest $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoriesRepository->store($request);
        return $this->sendResponse(new CategoryResource($category), 'success');
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->categoriesRepository->update($request, $category);
        return $this->sendResponse(new CategoryResource($category), 'success');
    }

    /**
     * @param Category $category
     * @return Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->sendResponse([], 'success');
    }
}
