<?php


namespace App\Pages;


use App\Controllers\AddMaterialController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class AddMaterialsPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private AddMaterialController $addMaterialController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        AddMaterialController $addMaterialController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->addMaterialController = $addMaterialController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $categories = $this->addMaterialController->getCategories(['parent_id' => 0]);

        $data = $this->twig->fetch('add-materials/add-materials.twig', [
            'title' => 'Доп.материалы',
            'user_name' => $userData['name'],
            'categories' => $categories
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function getCategory(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $path = $args['path'];
        $categoryData = $this->addMaterialController->getCategoryContent($path);

        $data = $this->twig->fetch('add-materials/add-materials-category.twig', [
            'title' => 'Доп.материалы',
            'user_name' => $userData['name'],
            'category_data' => $categoryData
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}