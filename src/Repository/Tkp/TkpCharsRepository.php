<?php

namespace App\Repository\Tkp;

use App\Interfaces\RepositoryInterface;
use App\Models\Tkp\TkpChars;

class TkpCharsRepository implements RepositoryInterface
{
    private TkpChars $tkpChars;

    public function __construct(TkpChars $tkpChars) {
        $this->tkpChars = $tkpChars;
    }
    public function createRecord(array $createArr): void
    {
        $this->tkpChars::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->tkpChars::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->tkpChars::where('id', $id)->delete();
    }

    public function getRecordByTkp(int $tkpId): ?array {
        return $this->tkpChars::where('tkp_id',$tkpId)->orderBy('tkp_param_id','ASC')->get()->toArray();
    }
}