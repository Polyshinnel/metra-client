<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class Tkp extends Model
{
    protected $table = 'tkp';
    protected $fillable = [
        'id',
        'name',
        'path',
        'category_id'
    ];
    public $timestamps = false;
}