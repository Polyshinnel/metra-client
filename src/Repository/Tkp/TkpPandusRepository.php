<?php

namespace App\Repository\Tkp;

use App\Models\Tkp\TkpOgrada;
use App\Models\Tkp\TkpPandus;

class TkpPandusRepository
{
    private TkpPandus $tkpPandus;

    public function __construct(TkpPandus $tkpPandus) {
        $this->tkpPandus = $tkpPandus;
    }

    public function getProducts($tkpId) {
        return $this->tkpPandus->where('tkp_id', $tkpId)->get()->toArray();
    }
}