<?php

namespace App\Repository\Tkp;

use App\Interfaces\RepositoryInterface;
use App\Models\Tkp\TkpParams;

class TkpParamRepository implements RepositoryInterface
{
    private TkpParams $tkpParams;

    public function __construct(TkpParams $tkpParams){
        $this->tkpParams = $tkpParams;
    }

    public function createRecord(array $createArr): void
    {
       $this->tkpParams::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->tkpParams::where('id',$id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->tkpParams::where('id',$id)->delete();
    }

    public function getRecordById(int $id): ?array {
        return $this->tkpParams::where('id',$id)->first()->toArray();
    }
}