<?php


namespace App\Pages;


use App\Controllers\TkpController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class TkpPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private TkpController $tkpController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        TkpController $tkpController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->tkpController = $tkpController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $params = $request->getQueryParams();
        $activeCategory = 1;
        if(isset($params['category'])) {
            $activeCategory = $params['category'];
        }

        $tkpCategories = $this->tkpController->getTkpCategories($activeCategory);
        $tkpCategoriesParams = $this->tkpController->getTkpCategoriesParams($activeCategory);


        $data = $this->twig->fetch('tkp/tkp-construct.twig', [
            'title' => 'Конструктор ТКП',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'categories' => $tkpCategories,
            'category_params' => $tkpCategoriesParams
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}