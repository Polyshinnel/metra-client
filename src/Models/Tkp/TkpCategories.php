<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class TkpCategories extends Model
{
    protected $table = 'tkp_categories';
    protected $fillable = [
        'id',
        'name',
        'img'
    ];
    public $timestamps = false;
}