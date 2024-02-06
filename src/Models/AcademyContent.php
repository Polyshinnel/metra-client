<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyContent extends Model
{
    protected $table = 'academy_content';
    protected $fillable = [
        'id',
        'name',
        'icon',
        'type',
        'category_id',
        'path'
    ];
    public $timestamps = false;
}