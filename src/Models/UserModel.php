<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public $timestamps = false;
    protected $table = 'users';
    protected $fillable = [
        'id',
        'name',
        'inn',
        'org_name',
        'org_addr',
        'mail',
        'phone',
        'country',
        'password',
        'status',
        'restore_token',
    ];
}