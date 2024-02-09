<?php


namespace App\Pages;


use App\Controllers\NewsController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class NewsPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private NewsController $newsController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController,
        NewsController $newsController
    )
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->newsController = $newsController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $news = $this->newsController->getAllNews();

        $data = $this->twig->fetch('news/news.twig', [
            'title' => 'Новости',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'news' => $news
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function getNews(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $newsId = $args['id'];
        $newsData = $this->newsController->getNewsById($newsId);

        $data = $this->twig->fetch('news/news-article.twig', [
            'title' => 'Новости',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'news_data' => $newsData
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}