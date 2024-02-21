<?php

namespace App\Controllers;

use App\Repository\Tkp\TkpBuildMaterialsRepository;
use App\Repository\Tkp\TkpCategoryRepository;
use App\Repository\Tkp\TkpCharsRepository;
use App\Repository\Tkp\TkpParamRepository;
use App\Repository\Tkp\TkpRepository;

class TkpController
{
    private TkpCategoryRepository $tkpCategoryRepository;
    private TkpCharsRepository $tkpCharsRepository;
    private TkpRepository $tkpRepository;
    private TkpParamRepository $tkpParamRepository;
    private TkpBuildMaterialsRepository $buildMaterialsRepository;

    public function __construct(
        TkpCategoryRepository $tkpCategoryRepository,
        TkpCharsRepository $tkpCharsRepository,
        TkpRepository $tkpRepository,
        TkpParamRepository $tkpParamRepository,
        TkpBuildMaterialsRepository $buildMaterialsRepository
    )
    {
        $this->tkpCategoryRepository = $tkpCategoryRepository;
        $this->tkpCharsRepository = $tkpCharsRepository;
        $this->tkpRepository = $tkpRepository;
        $this->tkpParamRepository = $tkpParamRepository;
        $this->buildMaterialsRepository = $buildMaterialsRepository;
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

    public function filteredTkpByChars(array $tkpParams, array $tkpValues, int $categoryId): ?array {
        $count = count($tkpParams);
        return $this->tkpRepository->filteredTkpByChars($categoryId,$tkpParams,$tkpValues,$count);
    }

    public function getNextParams(array $tkpParams, array $tkpValues, int $categoryId): ?array {

        $tkpList = $this->filteredTkpByChars($tkpParams,$tkpValues,$categoryId);
        $categoryParams = [];
        $categoryUnique = [];
        if(!empty($tkpList[0]['tkp_id'])) {
            foreach ($tkpList as $tkpItem) {
                $tkpId = $tkpItem['tkp_id'];
                $tkpChars = $this->tkpCharsRepository->getRecordByTkp($tkpId);
                if(!empty($tkpChars)) {
                    foreach ($tkpChars as $char) {
                        $categoryParams[$char['tkp_param_id']][] = $char['value'];
                    }
                }
            }
        }

        if($categoryParams) {
            foreach ($categoryParams as $key=>$value) {
                $paramData = $this->tkpParamRepository->getRecordById($key);
                $categoryUnique[$key]['id'] = $paramData['id'];
                $categoryUnique[$key]['name'] = $paramData['name'];
                $categoryUnique[$key]['chars'] = array_unique($value);
            }
        }

        foreach ($tkpParams as $param) {
            unset($categoryUnique[$param]);
        }

        return $categoryUnique;
    }

    public function getTkpAndMaterials(int $tkpId): ?array {
        $tkp = $this->tkpRepository->getTkpById($tkpId);
        $buildMaterials = [];
        $materialsResult = $this->buildMaterialsRepository->getRecordsByTkpId($tkpId);
        if($materialsResult) {
            $buildMaterials = $materialsResult;
        }
        return [
            'tkp' => $tkp,
            'build_materials' => $buildMaterials
        ];
    }
}