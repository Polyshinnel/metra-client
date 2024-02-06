<?php

namespace App\Controllers;

use App\Repository\AddMaterialCategoryRepository;
use App\Repository\AddMaterialContentRepository;

class AddMaterialController
{
    private AddMaterialCategoryRepository $addMaterialCategoryRepository;
    private AddMaterialContentRepository $addMaterialContentRepository;

    public function __construct(
        AddMaterialCategoryRepository $addMaterialCategoryRepository,
        AddMaterialContentRepository $addMaterialContentRepository
    )
    {
        $this->addMaterialCategoryRepository = $addMaterialCategoryRepository;
        $this->addMaterialContentRepository = $addMaterialContentRepository;
    }

    public function getCategories(array $filter): ?array {
        return $this->addMaterialCategoryRepository->getCategories($filter);
    }

    public function getCategoryContent(string $categoryPath) {
        $categoryInfoArr = $this->addMaterialCategoryRepository->getCategories(['path' => $categoryPath]);
        $categoryId = $categoryInfoArr[0]['id'];
        $content = $this->addMaterialContentRepository->getCategoryContent($categoryId);
        return [
            'category_data' => $categoryInfoArr[0],
            'content' => $content
        ];
    }
}