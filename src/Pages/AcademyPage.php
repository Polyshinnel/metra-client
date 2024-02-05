<?php


namespace App\Pages;


use App\Controllers\UserController;
use App\Controllers\VebinarController;
use App\Repository\VebinarRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class AcademyPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private VebinarController $vebinarController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        VebinarController $vebinarController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->vebinarController = $vebinarController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('academy/academy.twig', [
            'title' => 'Академия метра',
            'user_name' => $userData['name']
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function vebinars(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $vebinars = $this->vebinarController->getAllVebinars();

        $data = $this->twig->fetch('academy/vebinars.twig', [
            'title' => 'Вебинары',
            'user_name' => $userData['name'],
            'vebinars' => $vebinars
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function vebinarPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $vebinarId = $args['id'];
        $vebinarData = $this->vebinarController->getVebinarById($vebinarId);
        $data = $this->twig->fetch('academy/vebinar-page.twig', [
            'title' => 'Вебинары',
            'user_name' => $userData['name'],
            'vebinar_data' => $vebinarData
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}