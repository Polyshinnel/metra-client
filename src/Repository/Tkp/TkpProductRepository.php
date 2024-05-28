<?php

namespace App\Repository\Tkp;

use App\Models\Tkp\TkpPandus;
use App\Models\Tkp\TkpProducts;

class TkpProductRepository
{
    private TkpProducts $tkpProducts;

    public function __construct(TkpProducts $tkpProducts) {
        $this->tkpProducts = $tkpProducts;
    }

    public function getProducts($tkpId) {
        return $this->tkpProducts->where('tkp_id', $tkpId)->get()->toArray();
    }
}