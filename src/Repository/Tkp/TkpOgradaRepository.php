<?php

namespace App\Repository\Tkp;

use App\Models\Tkp\TkpNastil;
use App\Models\Tkp\TkpOgrada;

class TkpOgradaRepository
{
    private TkpOgrada $tkpOgrada;

    public function __construct(TkpOgrada $tkpOgrada) {
        $this->tkpOgrada = $tkpOgrada;
    }

    public function getProducts($tkpId) {
        return $this->tkpOgrada->where('tkp_id', $tkpId)->get()->toArray();
    }
}