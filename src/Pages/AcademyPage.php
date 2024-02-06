<?php


namespace App\Pages;


use App\Controllers\AcademyController;
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
    private AcademyController $academyController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        VebinarController $vebinarController,
        AcademyController $academyController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->vebinarController = $vebinarController;
        $this->academyController = $academyController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $academyCategories = $this->academyController->getAcademyCategories(['parent_id' => 0]);

        $data = $this->twig->fetch('academy/academy.twig', [
            'title' => 'Академия метра',
            'user_name' => $userData['name'],
            'academy_categories' => $academyCategories
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function categories(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $path = $args['path'];
        $categoryContent = $this->academyController->getAcademyCategoryContent($path);

        $data = $this->twig->fetch('academy/academy-category.twig', [
            'title' => 'Академия метра',
            'user_name' => $userData['name'],
            'category_content' => $categoryContent
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function getContentPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $content = $this->academyController->getAcademyPage($args);

        $data = $this->twig->fetch('academy/academy-content-page.twig', [
            'title' => 'Академия метра',
            'user_name' => $userData['name'],
            'content_data' => $content
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