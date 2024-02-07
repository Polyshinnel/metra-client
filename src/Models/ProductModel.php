<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    public $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'img',
        'sku',
        'price',
        'export_price',
        'category_id',
        'description',
        'status'
    ];
    public $timestamps = false;
}