<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class TkpChars extends Model
{
    protected $table = 'tkp_chars';
    protected $fillable = [
        'id',
        'tkp_id',
        'tkp_param_id',
        'value'
    ];
    public $timestamps = false;
}