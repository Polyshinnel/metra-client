<?php

namespace App\Repository;

use App\Models\AcademyPages;

class AcademyPageRepository
{
    private AcademyPages $academyPages;

    public function __construct(AcademyPages $academyPages)
    {
        $this->academyPages = $academyPages;
    }

    public function createAcademyPage(array $createArr): void {
        $this->academyPages::create($createArr);
    }

    public function updateAcademyPage(int $id, array $updateArr): void {
        $this->academyPages::where('id', $id)->update($updateArr);
    }

    public function deleteAcademyPage(int $id): void {
        $this->academyPages::where('id', $id)->delete();
    }

    public function getContentByPath(string $path): ?array {
        return $this->academyPages::where('path', $path)->first()->toArray();
    }
}