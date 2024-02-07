<?php

namespace App\Controllers;

use ErrorException;
use Exception;

class ParserController
{
    private ProductController $productController;

    public function __construct(ProductController $productController) {
        $this->productController = $productController;
    }

    private function checkProductImg(string $path): bool {
        set_error_handler(function ($level, $message, $file = '', $line = 0)
        {
            throw new ErrorException($message, 0, $level, $file, $line);
        });

        $pathInfo = pathinfo($path);
        $extension = '';
        if(isset($pathInfo['extension'])) {
            $extension = $pathInfo['extension'];
        }

        $filePath = __DIR__.'/../../exchange/images/'.$pathInfo['basename'];

        if(file_exists($filePath)) {

            if($extension == 'png') {
                try {
                    if(imagecreatefrompng($filePath) !== false ) {
                        return true;
                    }
                } catch (Exception $exception) {
                    return false;
                }
            }

            if(($extension == 'jpg') || ($extension == 'jpeg')) {
                try {
                    if(imagecreatefromjpeg($filePath) !== false ) {
                        return true;
                    }
                } catch (Exception $exception) {
                    return false;
                }
            }
        }


        return false;
    }

    private function getProducts(?string $path = NULL): ?array {
        $xmlPath = $path;
        if(!$path) {
            $xmlPath = __DIR__.'/../../exchange/products.xml';
        }

        $xml = simplexml_load_file($xmlPath);
        $products = [];
        foreach ($xml as $item) {
            $status = 0;

            $quantity = (int)$item->quantity_product;
            if($quantity > 0) {
                $status = 1;
            }

            $img = '/assets/img/no-image.jpg';
            $xmlImg = $item->img;
            if($this->checkProductImg($xmlImg)) {
                $img = $xmlImg;
            }

            $products[] = [
                'name' => (string)$item->name_product,
                'img' => (string)$img,
                'sku' => (string)$item->articul,
                'price' => (int)$item->price,
                'export_price' => (int)$item->kz_price,
                'category_id' => (int)$item->category,
                'description' => (string)$item->description,
                'status' => $status,
            ];
        }

        return $products;
    }

    private function checkProductInDB(array $product): ?array {
        $filter = [
            'name' => $product['name'],
            'sku' => $product['sku']
        ];
        $productInfo = $this->productController->getProducts($filter);
        if(!empty($productInfo)){
            return $productInfo[0];
        }

        return NULL;
    }

    private function updateProduct(int $id, array $product): void {
        $updateArr = [
            'img' => $product['img'],
            'description' => $product['description'],
            'price' => $product['price'],
            'export_price' => $product['export_price'],
            'status' => $product['status']
        ];
        $this->productController->updateProduct($id, $updateArr);
    }

    private function createProducts(array $product) {
        $this->productController->createProduct($product);
    }

    public function productProcessing(): array {
        $products = $this->getProducts();
        $processingResults = [
            'created' => 0,
            'updated' => 0
        ];

        foreach ($products as $product) {
            $productInfo = $this->checkProductInDB($product);
            if($productInfo) {
                if(
                    ($productInfo['img'] != $product['img']) ||
                    ($productInfo['description'] != $product['description']) ||
                    ($productInfo['price'] != $product['price']) &&
                    ($productInfo['export_price'] != $product['export_price']) ||
                    ($productInfo['status'] != $product['status'])
                ) {
                    $productId = $productInfo['id'];
                    $this->updateProduct($productId, $product);
                    $updateCount = $processingResults['updated'] + 1;
                    $processingResults['updated'] = $updateCount;
                }
            } else {
                $this->createProducts($product);
                $createCount = $processingResults['created'] + 1;
                $processingResults['created'] = $createCount;
            }
        }

        return $processingResults;
    }
}