<?php


namespace App\Pages;


use App\Controllers\UserController;
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
    private UserController $userController;

    public function __construct(Twig $twig, ResponseFactoryInterface $responseFactory, UserController $userController)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();
        $errClass = '';

        if(isset($params['err'])) {
            $errClass = 'error-input';
        }

        if(isset($_COOKIE["user"])) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $data = $this->twig->fetch('service-page/auth.twig', [
            'err_class' => $errClass
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function authorize(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();


        $login = $params['login'];
        $pass = $params['password'];

        $userData = $this->userController->authUser($login, $pass);



        if(!empty($userData))
        {
            if($userData['status'] != 0) {
                setcookie("user", $userData['id'], time() + 3600*8);

                $response = $this->responseFactory->createResponse();
                return $response->withHeader('Location','/')->withStatus(302);
            }

            $response = $this->responseFactory->createResponse();
            return $response->withHeader('Location','/err-entry')->withStatus(302);
        }



        $response = $this->responseFactory->createResponse();
        return $response->withHeader('Location','/auth?err=true')->withStatus(302);
    }

    public function error(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('notifications/err-entry.twig');
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}