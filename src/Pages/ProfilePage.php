<?php


namespace App\Pages;


use App\Controllers\NotificationController;
use App\Controllers\UserController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ProfilePage
{
    private Twig $twig;
    private ResponseFactoryInterface $responseFactory;
    private UserController $userController;
    private NotificationController $notificationController;

    public function __construct(Twig $twig, ResponseFactoryInterface $responseFactory, UserController $userController, NotificationController $notificationController)
    {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->userController = $userController;
        $this->notificationController = $notificationController;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/profile.twig', [
            'title' => 'Профиль',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'email' => $userData['mail'],
            'inn' => $userData['inn'],
            'org_name' => $userData['org_name'],
            'org_addr' => $userData['org_addr'],
            'phone' => $userData['phone'],
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function updateProfile(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        $userName = $params['user-name'];
        $email = $params['user-email'];
        $inn = $params['inn'];
        $orgName = $params['organization-name'];
        $orgAddr = $params['organization-addres'];
        $phone = $params['user-phone'];

        $userId = $_COOKIE['user'];
        $this->userController->updateUserProfile($userId, $userName, $email, $inn, $orgName, $orgAddr, $phone);


        $response = $this->responseFactory->createResponse();
        return $response->withHeader('Location','/profile')->withStatus(302);
    }

    public function updatePassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $params = $request->getParsedBody();

        $password = $params['password'];
        $newPassword = $params['new-password'];

        $checkPass = $this->userController->checkUserPassword($password, $userId);
        $data = [
            'msg' => 'wrong curr password'
        ];

        if($checkPass) {
            $this->userController->changePassword($newPassword, $userId);
            $data = [
                'msg' => 'password was changed'
            ];
        }

        $json = json_encode($data);

        return new Response(
            200,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream($json)
        );
    }

    public function notification(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);
        $notifications = $this->notificationController->getUserNotifications($userId);


        $data = $this->twig->fetch('profile/notification.twig', [
            'title' => 'Оповещения',
            'user_name' => $userData['name'],
            'notification_count' => $userData['notification_count'],
            'notifications' => $notifications
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function updateNotificaionStatus(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $params = $request->getParsedBody();
        $jsonArr = [
            'msg' => 'err'
        ];
        if(isset($params['notification_id'])) {
            $this->notificationController->updateNotificationStatus($userId, $params['notification_id']);
            $jsonArr['msg'] = 'success';
        }

        $data = json_encode($jsonArr);
        return new Response(
            200,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function clients(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/clients.twig', [
            'title' => 'Оповещения',
            'user_name' => $userData['name']
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function changePassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $_COOKIE['user'];
        $userData = $this->userController->getUserById($userId);

        $data = $this->twig->fetch('profile/change-password.twig', [
            'title' => 'Смена пароля',
            'user_name' => $userData['name']
        ]);


        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}