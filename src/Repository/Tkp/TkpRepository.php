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

    public function filteredTkpByChars(int $categoryId, array $tkpParams, array $tkpValues, int $count): ?array {
        return $this->tkp::select(
            'tkp_chars.tkp_id',
            'tkp.name',
            'tkp_categories.img',
        )
            ->leftjoin('tkp_chars','tkp.id','=','tkp_chars.tkp_id')
            ->leftjoin('tkp_categories','tkp.category_id','=','tkp_categories.id')
            ->where('tkp.category_id',$categoryId)
            ->whereIn('tkp_chars.tkp_param_id',$tkpParams)
            ->whereIn('tkp_chars.value',$tkpValues)
            ->groupBy('tkp_chars.tkp_id')
            ->havingRaw('COUNT(*) ='.$count)
            ->get()
            ->toArray();
    }

    public function filteredTkp(array $filter): ?array {
        return $this->tkp::where($filter)->get()->toArray();
    }

    public function getTkpById(int $id): ?array {
        return $this->tkp::select(
            'tkp.id',
            'tkp.name',
            'tkp_categories.img',
        )
            ->leftjoin('tkp_categories','tkp.category_id','=','tkp_categories.id')
            ->where('tkp.id',$id)
            ->first()
            ->toArray();
    }
}