<?php

namespace App\Repository;

use App\Models\AcademyContent;

class AcademyCategoryContent
{
    private AcademyContent $academyContent;

    public function __construct(AcademyContent $academyContent) {
        $this->academyContent = $academyContent;
    }

    public function createContentCategory(array $createArr): void {
        $this->academyContent::create($createArr);
    }

    public function updateContentCategory(int $id, array $updateArr): void {
        $this->academyContent::where('id', $id)->update($updateArr);
    }

    public function deleteContentCategory(int $id): void {
        $this->academyContent::where('id', $id)->delete();
    }

    public function getAcademyCategoryContent(int $categoryId): ?array {
        return $this->academyContent::where('category_id', $categoryId)->get()->toArray();
    }
}