<?php

namespace App\Repository;

use App\Models\AddMaterialContent;

class AddMaterialContentRepository
{
    private AddMaterialContent $addMaterialContent;

    public function __construct(AddMaterialContent $addMaterialContent) {
        $this->addMaterialContent = $addMaterialContent;
    }

    public function createAddMaterialContent(array $createArr): void {
        $this->addMaterialContent::create($createArr);
    }

    public function updateAddMaterialContent(int $id, array $updateArr): void {
        $this->addMaterialContent::where('id', $id)->update($updateArr);
    }

    public function deleteAddMaterialContent(int $id): void {
        $this->addMaterialContent::where('id', $id)->delete();
    }

    public function getCategoryContent(int $categoryId): ?array {
        return $this->addMaterialContent::where('category_id', $categoryId)->get()->toArray();
    }
}