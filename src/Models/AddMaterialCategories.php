<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddMaterialCategories extends Model
{
    protected $table = 'add_material_category';
    protected $fillable = [
        'id',
        'name',
        'img',
        'parent_id',
        'path'
    ];
    public $timestamps = false;
}