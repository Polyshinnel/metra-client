<?php

namespace App\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\ProductModel;

class ProductRepository implements RepositoryInterface
{
    private ProductModel $productModel;

    public function __construct(ProductModel $productModel) {
        $this->productModel = $productModel;
    }

    public function createRecord(array $createArr): void
    {
        $this->productModel::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->productModel::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->productModel::where('id', $id)->delete();
    }

    public function getFilteredProducts(array $filter): ?array {
        return $this->productModel::where($filter)->get()->toArray();
    }
}