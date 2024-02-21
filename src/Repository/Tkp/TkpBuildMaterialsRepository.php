<?php

namespace App\Repository\Tkp;

use App\Interfaces\RepositoryInterface;
use App\Models\Tkp\TkpBuildMaterials;

class TkpBuildMaterialsRepository implements RepositoryInterface
{
    private TkpBuildMaterials $tkpBuildMaterials;

    public function __construct(TkpBuildMaterials $tkpBuildMaterials) {
        $this->tkpBuildMaterials = $tkpBuildMaterials;
    }

    public function createRecord(array $createArr): void
    {
        $this->tkpBuildMaterials::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->tkpBuildMaterials::where('id',$id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->tkpBuildMaterials::where('id',$id)->delete();
    }

    public function getRecordsByTkpId(int $tkpId): ?array {
        return $this->tkpBuildMaterials::where('tkp_id',$tkpId)->get()->toArray();
    }
}