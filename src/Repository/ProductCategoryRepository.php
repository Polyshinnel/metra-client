<?php

namespace App\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\ProductCategoryModel;

class ProductCategoryRepository implements RepositoryInterface
{
    private ProductCategoryModel $productCategoryModel;

    public function __construct(ProductCategoryModel $productCategoryModel) {
        $this->productCategoryModel = $productCategoryModel;
    }

    public function createRecord(array $createArr): void
    {
        $this->productCategoryModel::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->productCategoryModel::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->productCategoryModel::where('id', $id)->delete();
    }

    public function getFilteredCategory(array $filter): ?array {
        return $this->productCategoryModel::where($filter)->get()->toArray();
    }
}