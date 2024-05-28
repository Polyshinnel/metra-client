<?php

namespace App\Repository\Tkp;

use App\Models\Tkp\TkpNastil;

class TkpNastilRepository
{
    private TkpNastil $tkpNastil;

    public function __construct(TkpNastil $tkpNastil) {
        $this->tkpNastil = $tkpNastil;
    }

    public function getProducts($tkpId) {
        return $this->tkpNastil->where('tkp_id', $tkpId)->get()->toArray();
    }
}