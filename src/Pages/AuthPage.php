<?php


namespace App\Pages;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthPage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;

    public function __construct(Twig $twig,  ResponseFactoryInterface $responseFactory)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('service-page/auth.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function authorize(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();


        $login = $params['username'];
        $pass = md5($params['pass']);

        $selectRequest = [
            'name' => $login,
            'password' => $pass
        ];

        $authResult = 'Не правильный логин и/или пароль';

        $userData = $this->userRepository->getFilteredUsers($selectRequest);
        if(!empty($userData))
        {
            setcookie("user", $login, time() + 3600*8);
            $authResult = 'AuthSuccess';

            $response = $this->responseFactory->createResponse();
            return $response->withHeader('Location','/deals')->withStatus(302);
        }



        $response = $this->responseFactory->createResponse();
        return $response->withHeader('Location','/auth?err=true')->withStatus(302);
    }
}