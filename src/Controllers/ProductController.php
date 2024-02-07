<?php

namespace App\Controllers;

use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;

class ProductController
{
    private ProductCategoryRepository $productCategoryRepository;
    private ProductRepository $productRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository, ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getCategories(array $filter): ?array {
        return $this->productCategoryRepository->getFilteredCategory($filter);
    }

    public function getAllCatalogParents(int $id): ?array {
        $categoryList = [];
        $flag = 1;
        $baseCategoryInfoArr = $this->getCategories(['id' => $id]);
        if($baseCategoryInfoArr[0]['parent_id'] == 0) {
            $flag = 0;
        }
        $categoryList[] = $baseCategoryInfoArr[0];
        while ($flag > 0) {
            $lastCategory = $categoryList[(count($categoryList) - 1)];
            $parentCategoryInfo = $this->getCategories(['id' => $lastCategory['parent_id']]);
            $categoryList[] = $parentCategoryInfo[0];
            if($parentCategoryInfo[0]['parent_id'] == 0) {
                $flag = 0;
            }
        }

        return array_reverse($categoryList);
    }

    public function getProducts(array $filter, string $country = 'ru'): ?array {
        $products = [];
        $productsRaw = $this->productRepository->getFilteredProducts($filter);
        if($country == 'ru') {
            return $productsRaw;
        }

        foreach ($productsRaw as $product) {
            $product['price'] = $product['export_price'];
            $products[] = $product;
        }

        return $products;
    }

    public function createProduct(array $createArr): void {
        $this->productRepository->createRecord($createArr);
    }

    public function updateProduct(int $id, array $updateArr): void {
        $this->productRepository->updateRecord($id, $updateArr);
    }
}