<?php

namespace App\Models\Tkp;

use Illuminate\Database\Eloquent\Model;

class TkpBuildMaterials extends Model
{
    protected $table = 'tkp_build_materials';
    protected $fillable = [
        'id',
        'name',
        'tkp_id',
        'path'
    ];
    public $timestamps = false;
}