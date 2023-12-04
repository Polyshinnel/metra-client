<?php


namespace App\Pages;


use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ForgottenPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;

    public function __construct(Twig $twig, ResponseFactoryInterface $responseFactory)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('service-page/forgotten-password.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function change(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();

        if(!empty($params)) {
            $data = $this->twig->fetch('service-page/forgotten-password-change.twig');
            return new Response(
                200,
                new Headers(['Content-Type' => 'text/html']),
                (new StreamFactory())->createStream($data)
            );
        }
        return $response->withHeader('Location','/err-restore')->withStatus(302);
    }

    public function error(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('notifications/err-restore.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function success(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('notifications/success-change-pass.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

}