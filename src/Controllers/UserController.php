<?php


namespace App\Controllers;


use App\Repository\UserRepository;

class UserController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authUser($login, $password) {
        $selectArr = [
            'mail' => $login,
            'password' => md5($password)
        ];
        $result = $this->userRepository->getUser($selectArr);

        if(!empty($result)) {
            return $result[0]['id'];
        }

        return NULL;
    }

    public function getUserByMail($mail) {
        $selectArr = [
            'mail' => $mail
        ];

        $result = $this->userRepository->getUser($selectArr);
        if(!empty($result)) {
            return $result[0];
        }

        return NULL;
    }
}