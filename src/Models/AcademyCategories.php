<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyCategories extends Model
{
    protected $table = 'academy_categories';
    protected $fillable = [
        'id',
        'name',
        'img',
        'path',
        'parent_id'
    ];
    public $timestamps = false;
}