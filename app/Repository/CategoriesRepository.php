<?php

namespace App\Repository;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Baum\Extensions\Eloquent\Collection;

class CategoriesRepository
{
    /**
     * @return Collection<Category>
     */
    public function findRootCategories(): Collection
    {
        return Category::roots()->get();
    }

    /**
     * @param $parentId
     * @return Collection<Category>
     */
    public function findChildren($parentId): Collection
    {
        return Category::where('parent_id', $parentId)->get();
    }

    /**
     * @param CategoryRequest $storeRequest
     * @return Category
     */
    public function store(CategoryRequest $storeRequest): Category
    {
        /** @var Category $newCategory */
        $newCategory = Category::create(['name' => $storeRequest->input('name')]);

        $parent = $this->extractParent($storeRequest);

        if ($parent) {
            $newCategory->makeChildOf($parent);
        }

        return $newCategory;
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @param Category $category
     * @return Category
     */
    public function update(CategoryRequest $categoryRequest, Category $category): Category
    {
        $parent = $this->extractParent($categoryRequest);
        if ($parent) {
            $category->parent_id = $parent->id;
        }
        $category->name = $categoryRequest->input('name');
        $category->save();

        return $category;
    }

    /**
     * @param CategoryRequest $storeRequest
     * @return Category|null
     */
    public function extractParent(CategoryRequest $storeRequest): ?Category
    {
        $parentId = $storeRequest->input('parent_id');
        $parent = null;
        if ($parentId) {
            /** @var Category $parent */
            $parent = Category::find($parentId);
        }
        return $parent;
    }

    /**
     * @param Category $category
     * @return Collection
     */
    public function getProductsByCategory(Category $category)
    {
        return $category->products()->get();
    }
}
