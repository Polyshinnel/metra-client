<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'id',
        'news_title',
        'news_short',
        'news_img',
        'news_html',
        'date_create'
    ];
    public $timestamps = false;
}