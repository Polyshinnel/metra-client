<?php

namespace App\Controllers;
use App\Repository\ClientsRepository;

class ClientController
{
    private ClientsRepository $clientsRepository;

    public function __construct(ClientsRepository $clientsRepository) {
        $this->clientsRepository = $clientsRepository;
    }

    public function getClients(int $userId): ?array {
        return $this->clientsRepository->getAllRecords($userId);
    }

    public function createClient(int $userId, array $params): string {
        $createArr = [
            'user_id' => $userId,
            'inn' => $params['inn'],
            'name' => $params['name'],
            'address' => $params['address'],
            'contact_name' => $params['contact_name'],
            'phone' => $params['phone']
        ];
        $this->clientsRepository->createRecord($createArr);
        $jsonArr = [
            'msg' => 'client was created'
        ];
        return json_encode($jsonArr);
    }

    public function updateClient($params): string {
        $updateArr = [
            'inn' => $params['inn'],
            'name' => $params['name'],
            'address' => $params['address'],
            'contact_name' => $params['contact_name'],
            'phone' => $params['phone']
        ];
        $this->clientsRepository->updateRecord($params['client_id'], $updateArr);
        $jsonArr = [
            'msg' => 'client was updated'
        ];
        return json_encode($jsonArr);
    }

    public function deleteRecord(int $id): string {
        $this->clientsRepository->deleteRecord($id);
        $jsonArr = [
            'msg' => 'client was deleted'
        ];
        return json_encode($jsonArr);
    }

    public function getClientById(int $id): string {
        $result = $this->clientsRepository->getRecordById($id);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}