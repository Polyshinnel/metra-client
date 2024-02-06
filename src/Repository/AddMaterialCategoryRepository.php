<?php

namespace App\Repository;

use App\Models\AddMaterialCategories;

class AddMaterialCategoryRepository
{
    private AddMaterialCategories $addMaterialCategories;

    public function __construct(AddMaterialCategories $addMaterialCategories)
    {
        $this->addMaterialCategories = $addMaterialCategories;
    }

    public function createCategory(array $createArr): void {
        $this->addMaterialCategories::create($createArr);
    }

    public function updateCategory(int $id, array $updateArr): void {
        $this->addMaterialCategories::where('id', $id)->update($updateArr);
    }

    public function deleteCategory(int $id): void {
        $this->addMaterialCategories::where('id', $id)->delete();
    }

    public function getCategories(array $filter): ?array {
        return $this->addMaterialCategories::where($filter)->get()->toArray();
    }
}