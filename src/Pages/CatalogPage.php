<?php


namespace App\Pages;


use App\Controllers\ProductController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class CatalogPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private ProductController $productController;

    public function __construct(Twig $twig, ResponseFactoryInterface $responseFactory, UserController $userController, ProductController $productController)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->productController = $productController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $categories = $this->productController->getCategories(['parent_id' => 0]);

        $data = $this->twig->fetch('catalog/catalog.twig', [
            'title' => 'Каталог',
            'user_name' => $userData['name'],
            'categories' => $categories,
            'products' => [],
            'category_info' => ['id' => '', 'name' => 'Каталог'],
            'category_parents' => []
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function getCatalog(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $categoryId = $args['id'];

        $categories = $this->productController->getCategories(['parent_id' => $categoryId]);
        $products = $this->productController->getProducts(['category_id' => $categoryId], $userData['country']);
        $categoryParents = $this->productController->getAllCatalogParents($categoryId);
        $categoryInfo = array_pop($categoryParents);

        $data = $this->twig->fetch('catalog/catalog.twig', [
            'title' => 'Каталог',
            'user_name' => $userData['name'],
            'categories' => $categories,
            'products' => $products,
            'category_info' => $categoryInfo,
            'category_parents' => $categoryParents
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function getProduct(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $productArr = $this->productController->getProducts(['id' => $args['id']]);
        $categoryId = $productArr[0]['category_id'];
        $parentArr = $this->productController->getAllCatalogParents($categoryId);

        $data = $this->twig->fetch('catalog/product.twig', [
            'title' => 'Каталог',
            'user_name' => $userData['name'],
            'product' => $productArr[0],
            'parent_category' => $parentArr
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function search(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);


        $data = $this->twig->fetch('catalog/product.twig', [
            'title' => 'Каталог',
            'user_name' => $userData['name'],
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function post_search(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);


        $data = $this->twig->fetch('catalog/product.twig', [
            'title' => 'Каталог',
            'user_name' => $userData['name'],
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}