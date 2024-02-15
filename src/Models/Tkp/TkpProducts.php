<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class TkpProducts extends Model
{
    protected $table = 'tkp_products';
    protected $fillable = [
        'id',
        'tkp_id',
        'product_id'
    ];
    public $timestamps = false;
}