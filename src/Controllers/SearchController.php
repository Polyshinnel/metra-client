<?php

namespace App\Controllers;

class SearchController
{
    private ProductController $productController;
    private UserController $userController;

    public function __construct(ProductController $productController, UserController $userController) {
        $this->productController = $productController;
        $this->userController = $userController;
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
}