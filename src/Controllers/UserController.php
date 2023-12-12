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

    public function authUser($login, $password): ?array {
        $selectArr = [
            'mail' => $login,
            'password' => md5($password)
        ];
        $result = $this->userRepository->getUser($selectArr);

        if(!empty($result)) {
            return $result[0];
        }

        return NULL;
    }

    public function getUserByMail($mail): ?array {
        $selectArr = [
            'mail' => $mail
        ];

        $result = $this->userRepository->getUser($selectArr);
        if(!empty($result)) {
            return $result[0];
        }

        return NULL;
    }

    public function registerUser($name, $email, $organization, $phone, $country, $password): void {

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
            'admin_status' => 0,
            'restore_token' => ''
        ];

        $this->userRepository->createUser($createArr);
    }

    public function createRestoreToken($mail): ?string {
        $userInfo = $this->userRepository->getUser(['mail' => $mail]);
        if(!empty($userInfo)) {
            $userData = $userInfo[0];
            $token = $this->commonUtils->genToken();
            $this->userRepository->updateUser(['restore_token' => $token], $userData['id']);
            return $token;
        }
        return NULL;
    }

    public function getUserByToken($token): ?array {
        $userInfo = $this->userRepository->getUser(['restore_token' => $token]);
        if(!empty($userInfo)) {
            return $userInfo[0];
        }
        return NULL;
    }

    public function changePassword($password, $id): void {
        $updateArr = [
            'password' => md5($password),
            'restore_token' => ''
        ];
        $this->userRepository->updateUser($updateArr, $id);
    }

    public function getUserById($id): ?array {
        $result = $this->userRepository->getUser(['id' => $id]);
        if(!empty($result)) {
            return $result[0];
        }

        return NULL;
    }

    public function updateUserProfile($userId, $userName, $email, $inn, $orgName, $orgAddr, $phone): void {
        $updateArr = [
            'name' => $userName,
            'inn' => $inn,
            'org_name' => $orgName,
            'org_addr' => $orgAddr,
            'mail' => $email,
            'phone' => $phone
        ];
        $this->userRepository->updateUser($updateArr, $userId);
    }

    public function checkUserPassword($password, $id): bool {
        $selectArr = [
            'id' => $id,
            'password' => md5($password)
        ];

        $result = $this->userRepository->getUser($selectArr);

        if(!empty($result)) {
            return true;
        }

        return false;
    }
}