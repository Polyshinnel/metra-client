<?php


namespace App\Pages;

use App\Controllers\BannerController;
use App\Controllers\NewsController;
use App\Controllers\UserController;
use App\Controllers\VebinarController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class IndexPage
{
    private Twig $twig;
    private UserController $userController;
    private ResponseFactoryInterface $responseFactory;
    private NewsController $newsController;
    private VebinarController $vebinarController;
    private BannerController $bannerController;

    public function __construct(
        Twig $twig,
        UserController $userController,
        ResponseFactoryInterface $responseFactory,
        NewsController $newsController,
        VebinarController $vebinarController,
        BannerController $bannerController
    )
    {
        $this->twig = $twig;
        $this->userController = $userController;
        $this->responseFactory = $responseFactory;
        $this->newsController = $newsController;
        $this->vebinarController = $vebinarController;
        $this->bannerController = $bannerController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $banners = $this->bannerController->getAllBanners();
        $news = $this->newsController->getLastNews(4);
        $vebinars = $this->vebinarController->getLimitedVebinars(4);
        $data = $this->twig->fetch('index.twig', [
            'title' => 'Главная',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'banners' => $banners,
            'news' => $news,
            'vebinars' => $vebinars
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function exit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        setcookie("user", '', time() - 3600*8);
        return $response->withHeader('Location','/auth')->withStatus(302);
    }
}