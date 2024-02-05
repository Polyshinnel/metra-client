<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VebinarsModel extends Model
{
    protected $table = 'vebinars';
    protected $fillable = [
        'id',
        'title',
        'video_link',
        'date_create'
    ];
    public $timestamps = false;
}