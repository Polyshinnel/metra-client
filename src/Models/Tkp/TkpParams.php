<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class TkpParams extends Model
{
    protected $table = 'tkp_params';
    protected $fillable = [
        'id',
        'name'
    ];
    public $timestamps = false;
}