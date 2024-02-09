<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientsModel extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'id',
        'user_id',
        'inn',
        'name',
        'address',
        'contact_name',
        'phone'
    ];
    public $timestamps = false;
}