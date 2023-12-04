<?php


namespace App\Repository;


use App\Models\UserModel;

class UserRepository
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser($createArr): void {
        $this->userModel::create($createArr);
    }

    public function updateUser($updateArr, $id): void {
        $this->userModel::where('id', $id)->update($updateArr);
    }

    public function getUser($selectArr): ?array {
        $result = $this->userModel::where($selectArr)->get()->toArray();
        if(!empty($result)){
            return $result;
        }
        return NULL;
    }
}