<?php

namespace App\Repository\Tkp;

use App\Interfaces\RepositoryInterface;
use App\Models\Tkp\Tkp;

class TkpRepository implements RepositoryInterface
{
    private Tkp $tkp;

    public function __construct(Tkp $tkp)
    {
        $this->tkp = $tkp;
    }

    public function createRecord(array $createArr): void
    {
        $this->tkp::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->tkp::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->tkp::where('id', $id)->delete();
    }

}