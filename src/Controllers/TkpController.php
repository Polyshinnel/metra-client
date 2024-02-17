<?php

namespace App\Controllers;

use App\Repository\Tkp\TkpCategoryRepository;
use App\Repository\Tkp\TkpCharsRepository;
use App\Repository\Tkp\TkpRepository;

class TkpController
{
    private TkpCategoryRepository $tkpCategoryRepository;
    private TkpCharsRepository $tkpCharsRepository;
    private TkpRepository $tkpRepository;

    public function __construct(
        TkpCategoryRepository $tkpCategoryRepository,
        TkpCharsRepository $tkpCharsRepository,
        TkpRepository $tkpRepository
    )
    {
        $this->tkpCategoryRepository = $tkpCategoryRepository;
        $this->tkpCharsRepository = $tkpCharsRepository;
        $this->tkpRepository = $tkpRepository;
    }

    public function getTkpCategories($activeCategory): ?array {
        $categories = [];
        $categoryResult = $this->tkpCategoryRepository->getAllCategories();
        if($categoryResult) {
            foreach ($categoryResult as $item) {
                $item['active'] = false;
                if($item['id'] == $activeCategory) {
                    $item['active'] = true;
                }
                $categories[] = $item;
            }
        }
        return $categories;
    }

    public function getTkpCategoriesParams(int $categoryId): ?array {
        $categoryParamsResult = $this->tkpCategoryRepository->getTkpCategoryParams($categoryId);
        $categoryParams = [];
        if($categoryParamsResult[0]['id']) {
            foreach ($categoryParamsResult as $categoryParam) {
                $paramId = $categoryParam['id'];
                $paramChars = $this->getTkpParamsChars($categoryId, $paramId);
                if($paramChars) {
                    foreach ($paramChars as $paramChar) {
                        $categoryParam['chars'][] = $paramChar['value'];
                    }
                }
                $categoryParams[] = $categoryParam;
            }
        }
        return $categoryParams;
    }

    public function getTkpParamsChars(int $categoryId, int $paramId): ?array {
        $filter = [
            'tkp_categories.id' => $categoryId,
            'tkp_chars.tkp_param_id' => $paramId
        ];
        return $this->tkpCategoryRepository->getFilteredTkpParams($filter);
    }
}