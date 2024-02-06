<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyPages extends Model
{
    protected $table = 'academy_pages';

    protected $fillable = [
        'id',
        'name',
        'html',
        'path'
    ];

    public $timestamps = false;
}