<?php


namespace App\Pages;


use App\Controllers\ProductController;
use App\Controllers\SearchController;
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
    private SearchController $searchController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        ProductController $productController,
        SearchController $searchController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->productController = $productController;
        $this->searchController = $searchController;
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
        $productArr = $this->productController->getProducts(['id' => $args['id']], $userData['country']);
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
        $params = $request->getQueryParams();
        $query = '';
        $products = [];
        if(!empty($params['query'])) {
            $query = $params['query'];
            $products = $this->searchController->searchProducts($query);
        }



        $data = $this->twig->fetch('catalog/search.twig', [
            'title' => 'Поиск',
            'user_name' => $userData['name'],
            'query' => $query,
            'products' => $products
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function post_search(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        $data = '';
        if(isset($params['query'])) {
            $data = $this->searchController->getJsonSearch($params['query']);
        }

        return new Response(
            200,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream($data)
        );
    }
}