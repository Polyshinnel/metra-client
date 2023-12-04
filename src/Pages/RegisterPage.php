<?php


namespace App\Pages;


use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class RegisterPage
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
        $data = $this->twig->fetch('service-page/register.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function registration(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();


        $response = $this->responseFactory->createResponse();
        return $response->withHeader('Location','/auth?err=true')->withStatus(302);
    }

    public function success(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('notifications/success-register.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

}