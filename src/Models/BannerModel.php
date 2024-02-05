<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'id',
        'link',
        'image',
        'title',
        'text',
        'text_btn',
        'order',
        'active'
    ];

    public $timestamps = false;
}