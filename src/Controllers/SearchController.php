<?php

namespace App\Controllers;

use App\Repository\Tkp\TkpCategoryRepository;
use App\Repository\Tkp\TkpRepository;

class SearchController
{
    private ProductController $productController;
    private UserController $userController;

    private TkpRepository $tkpRepository;
    private TkpCategoryRepository $tkpCategoryRepository;

    public function __construct(
        ProductController $productController,
        UserController $userController,
        TkpRepository $tkpRepository,
        TkpCategoryRepository $tkpCategoryRepository
    ) {
        $this->productController = $productController;
        $this->userController = $userController;
        $this->tkpRepository = $tkpRepository;
        $this->tkpCategoryRepository = $tkpCategoryRepository;
    }

    public function searchProducts(string $query): ?array {
        $searchFields = [
            'name',
            'sku',
            'description'
        ];

        $products = [];

        foreach ($searchFields as $searchField) {
            $filter = [
                [
                    $searchField,'LIKE','%'.$query.'%'
                ]
            ];

            $userId = $_COOKIE['user'];
            $userData = $this->userController->getUserById($userId);


            $searchResults = $this->productController->getProducts($filter, $userData['country']);
            if(!empty($searchResults)) {
                foreach ($searchResults as $searchResult) {
                    $products[] = $searchResult;
                }
            }
        }

        return $products;
    }

    public function getJsonSearch(string $query): string {
        $products = $this->searchProducts($query);
        $jsonArr = [
            'products' => $products
        ];
        return json_encode($jsonArr, JSON_UNESCAPED_UNICODE);
    }

    public function searchTkp(string $query): string {
        $filter = [
            [
                'name','LIKE','%'.$query.'%'
            ]
        ];
        $results = $this->tkpRepository->filteredTkp($filter);
        $tkpList = [];

        if(!empty($results)) {
            $categoryList = [];
            foreach ($results as $result) {
                $categoryId = $result['category_id'];
                if(!isset($categoryList[$categoryId])) {
                    $categoryInfo = $this->tkpCategoryRepository->getCategoryById($categoryId);
                    $categoryList[$categoryId] = $categoryInfo['img'];
                }
                $tkpList[] = [
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'img' => $categoryList[$categoryId]
                ];
            }
        }

        return json_encode($tkpList, JSON_UNESCAPED_UNICODE);
    }
}