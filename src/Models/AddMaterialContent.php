<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddMaterialContent extends Model
{
    protected $table = 'add_material_content';
    protected $fillable = [
        'id',
        'name',
        'icon',
        'category_id',
        'path'
    ];
    public $timestamps = false;
}