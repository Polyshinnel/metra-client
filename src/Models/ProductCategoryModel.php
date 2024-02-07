<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryModel extends Model
{
    protected $table = 'product_categories';
    protected $fillable = [
        'id',
        'name',
        'img',
        'parent_id'
    ];
    public $timestamps = false;
}