<?php


namespace App\Controllers;


use App\Repository\UserRepository;
use App\Utils\CommonUtil;

class UserController
{
    private UserRepository $userRepository;
    private CommonUtil $commonUtils;


    public function __construct(UserRepository $userRepository, CommonUtil $commonUtils)
    {
        $this->userRepository = $userRepository;
        $this->commonUtils = $commonUtils;
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

    public function registerUser($name, $email, $organization, $phone, $country, $password) {

        $createArr = [
            'name' => $name,
            'inn' => '',
            'org_name' => $organization,
            'org_addr' => '',
            'mail' => $email,
            'phone' => $phone,
            'country' => $country,
            'password' => md5($password),
            'status' => 0,
            'restore_token' => ''
        ];

        $this->userRepository->createUser($createArr);
    }

    public function createRestoreToken($mail) {
        $userInfo = $this->userRepository->getUser(['mail' => $mail]);
        if(!empty($userInfo)) {
            $userData = $userInfo[0];
            $token = $this->commonUtils->genToken();
            $this->userRepository->updateUser(['restore_token' => $token], $userData['id']);
            return $token;
        }
        return NULL;
    }

    public function getUserByToken($token) {
        $userInfo = $this->userRepository->getUser(['restore_token' => $token]);
        if(!empty($userInfo)) {
            return $userInfo[0];
        }
        return NULL;
    }

    public function changePassword($password, $id) {
        $updateArr = [
            'password' => md5($password),
            'restore_token' => ''
        ];
        $this->userRepository->updateUser($updateArr, $id);
    }
}