<?php

namespace App\Repository;

use App\Models\AcademyCategories;

class AcademyCategoriesRepository
{
    private AcademyCategories $academyCategories;

    public function __construct(AcademyCategories $academyCategories) {
        $this->academyCategories = $academyCategories;
    }

    public function addCategory(array $createArr): void {
        $this->academyCategories::create($createArr);
    }

    public function updateCategory(int $id, array $updateArr): void {
        $this->academyCategories::where('id', $id)->update($updateArr);
    }

    public function deleteCategory(int $id): void {
        $this->academyCategories::where('id', $id)->delete();
    }

    public function getCategories($filter): ?array {
        return $this->academyCategories::where($filter)->get()->toArray();
    }

    public function getCategoryById(int $id): ?array {
        return $this->academyCategories::where('id', $id)->first()->toArray();
    }

    public function getCategoryByPath(string $path): ?array {
        return $this->academyCategories::where('path', $path)->first()->toArray();
    }
}