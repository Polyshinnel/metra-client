<?php


namespace App\Pages;


use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ProfilePage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;

    public function __construct(Twig $twig, ResponseFactoryInterface $responseFactory, UserController $userController)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/profile.twig', [
            'title' => 'Новости',
            'user_name' => $userData['name']
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function notification(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/notification.twig', [
            'title' => 'Оповещения',
            'user_name' => $userData['name']
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function clients(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/clients.twig', [
            'title' => 'Оповещения',
            'user_name' => $userData['name']
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}