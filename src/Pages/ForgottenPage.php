<?php


namespace App\Pages;


use App\Controllers\UserController;
use App\Utils\CommonUtil;
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
    private UserController $userController;

    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        UserController $userController
    )
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
        $data = $this->twig->fetch('service-page/forgotten-password.twig', [
            'err_class' => $errClass
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function change(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();

        if(isset($params['token'])) {
            $token = $params['token'];
            $userInfo = $this->userController->getUserByToken($token);
            if(!empty($userInfo)) {
                $data = $this->twig->fetch('service-page/forgotten-password-change.twig', [
                    'token' => $token,
                    'mail' => $userInfo['mail']
                ]);
                return new Response(
                    200,
                    new Headers(['Content-Type' => 'text/html']),
                    (new StreamFactory())->createStream($data)
                );
            }
            return $response->withHeader('Location','/err-restore')->withStatus(302);
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

    public function successRequest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();


        if(isset($params['mail'])) {
            $mail = $params['mail'];
            $data = $this->twig->fetch('notifications/success-rest-request.twig', [
                'mail' => $mail
            ]);
            return new Response(
                200,
                new Headers(['Content-Type' => 'text/html']),
                (new StreamFactory())->createStream($data)
            );
        }

        return $response->withHeader('Location','/err-restore')->withStatus(302);
    }

    public function request(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        if(isset($params['mail'])){
            $mail = $params['mail'];
            $userData = $this->userController->getUserByMail($mail);

            if(!empty($userData)) {
                $queryParams = [
                    'mail' => $mail
                ];
                $query = '/success-restore-request?'.http_build_query($queryParams);
                $token = $this->userController->createRestoreToken($mail);

                return $response->withHeader('Location',$query)->withStatus(302);
            }
            return $response->withHeader('Location','/forgotten-password?err=true')->withStatus(302);
        }
        return $response->withHeader('Location','/forgotten-password?err=true')->withStatus(302);
    }

    public function changePassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface{
        $params = $request->getParsedBody();
        $token = '';
        $password = '';
        if(isset($params['token'])) {
            $token = $params['token'];
        }

        if(isset($params['password'])) {
            $password = $params['password'];
        }

        if(!empty($token) && !empty($password)) {
            $userData = $this->userController->getUserByToken($token);
            $id = $userData['id'];
            if(!empty($userData)) {
                $this->userController->changePassword($password, $id);
                return $response->withHeader('Location','/success-restore')->withStatus(302);
            }
            return $response->withHeader('Location','/err-restore')->withStatus(302);
        }

        return $response->withHeader('Location','/err-restore')->withStatus(302);
    }
}