<?php

namespace App\Repository\Tkp;

use App\Interfaces\RepositoryInterface;
use App\Models\Tkp\TkpCategories;

class TkpCategoryRepository implements RepositoryInterface
{
    private TkpCategories $tkpCategory;

    public function __construct(TkpCategories $tkpCategory) {
        $this->tkpCategory = $tkpCategory;
    }
    public function createRecord(array $createArr): void
    {
        $this->tkpCategory::create($createArr);
    }

    public function updateRecord(int $id, array $updateArr): void
    {
        $this->tkpCategory::where('id', $id)->update($updateArr);
    }

    public function deleteRecord(int $id): void
    {
        $this->tkpCategory::where('id', $id)->delete();
    }

    public function getAllCategories(): ?array {
        return $this->tkpCategory::all()->toArray();
    }

    public function getCategoryById(int $id): ?array {
        return $this->tkpCategory::where('id',$id)->first()->toArray();
    }

    public function getTkpCategoryParams(int $categoryId): ?array {
        return $this->tkpCategory::select(
            'tkp_params.id',
            'tkp_params.name',
        )
            ->leftjoin('tkp','tkp_categories.id','=','tkp.category_id')
            ->leftjoin('tkp_chars','tkp.id','=','tkp_chars.tkp_id')
            ->leftjoin('tkp_params','tkp_chars.tkp_param_id','=','tkp_params.id')
            ->where('tkp_categories.id', $categoryId)
            ->distinct()
            ->get()
            ->toArray();
    }

    public function getFilteredTkpParams($filter): ?array {
        return $this->tkpCategory::select(
            'tkp_chars.value'
        )
            ->leftjoin('tkp','tkp_categories.id','=','tkp.category_id')
            ->leftjoin('tkp_chars','tkp.id','=','tkp_chars.tkp_id')
            ->where($filter)
            ->distinct()
            ->get()
            ->toArray();
    }

}