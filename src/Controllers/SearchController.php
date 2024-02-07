<?php

namespace App\Controllers;

class SearchController
{
    private ProductController $productController;

    public function searchProducts($str) {
        $searchFields = [
            'name',
            'sku',
            'description'
        ];
    }
}