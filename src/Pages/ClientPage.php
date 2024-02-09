<?php

namespace App\Pages;

use App\Controllers\ClientController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ClientPage
{
    private Twig $twig;
    private UserController $userController;
    private ResponseFactoryInterface $responseFactory;
    private ClientController $clientController;

    public function __construct(
        Twig $twig,
        UserController $userController,
        ResponseFactoryInterface $responseFactory,
        ClientController $clientController
    )
    {
        $this->twig = $twig;
        $this->userController = $userController;
        $this->responseFactory = $responseFactory;
        $this->clientController = $clientController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $clients = $this->clientController->getClients($userId);
        $data = $this->twig->fetch('clients/clients.twig', [
            'title' => 'Главная',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'clients' => $clients
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

}