<?php

namespace App\Repository;

use App\Models\VebinarsModel;

class VebinarRepository
{
    private VebinarsModel $vebinarsModel;

    public function __construct(VebinarsModel $vebinarsModel) {
        $this->vebinarsModel = $vebinarsModel;
    }

    public function createVebinar(array $createArr): void {
        $this->vebinarsModel::create($createArr);
    }

    public function updateVebinar(int $id, array $updateArr): void {
        $this->vebinarsModel::where('id', $id)->update($updateArr);
    }

    public function deleteVebinar(int $id) {
        $this->vebinarsModel::where('id', $id)->delete();
    }

    public function getVebinarById(int $id): ?array {
        return $this->vebinarsModel::where('id', $id)->first()->toArray();
    }

    public function getAllVebinars(): ?array {
        return $this->vebinarsModel::orderBy('id', 'DESC')->get()->toArray();
    }

    public function getLimitVebinars(int $limit): ?array {
        return $this->vebinarsModel::orderBy('id', 'DESC')->offset(0)->limit($limit)->get()->toArray();
    }
}