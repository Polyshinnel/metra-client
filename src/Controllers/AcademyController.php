<?php

namespace App\Controllers;

use App\Repository\AcademyCategoriesRepository;
use App\Repository\AcademyCategoryContent;
use App\Repository\AcademyPageRepository;

class AcademyController
{
    private AcademyCategoriesRepository $academyCategoriesRepository;
    private AcademyCategoryContent $academyCategoryContent;
    private AcademyPageRepository $academyPageRepository;

    public function __construct(
        AcademyCategoriesRepository $academyCategoriesRepository,
        AcademyCategoryContent $academyCategoryContent,
        AcademyPageRepository $academyPageRepository
    )
    {
        $this->academyCategoriesRepository = $academyCategoriesRepository;
        $this->academyCategoryContent = $academyCategoryContent;
        $this->academyPageRepository = $academyPageRepository;
    }

    public function getAcademyCategories(array $filter): ?array {
        return $this->academyCategoriesRepository->getCategories($filter);
    }

    public function getAcademyCategoryContent(string $path): ?array {
        $categoryInfo = $this->academyCategoriesRepository->getCategoryByPath($path);
        $subCategory = $this->academyCategoriesRepository->getCategories(['parent_id' => $categoryInfo['id']]);
        $content = $this->academyCategoryContent->getAcademyCategoryContent($categoryInfo['id']);
        return [
            'parent_category_info' => $categoryInfo,
            'categories' => $subCategory,
            'content' => $content
        ];
    }

    public function getAcademyPage(array $pathArgs): ?array {
        $path = '/academy';
        foreach ($pathArgs as $item) {
            $path .= '/'.$item;
        }
        return $this->academyPageRepository->getContentByPath($path);
    }
}