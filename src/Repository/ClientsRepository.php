<?php

namespace App\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\ClientsModel;

class ClientsRepository implements RepositoryInterface
{
    private ClientsModel $clientsModel;

    public function __construct(ClientsModel $clientsModel) {
        $this->clientsModel = $clientsModel;
    }
    public function createRecord(array $createArr): void
    {
        $this->clientsModel::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->clientsModel::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->clientsModel::where('id', $id)->delete();
    }

    public function getAllRecords(int $user_id): ?array {
        return $this->clientsModel::where('user_id', $user_id)->get()->toArray();
    }
}