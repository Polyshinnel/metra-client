<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationModel extends Model
{
    protected $table = 'user_notifications';
    protected $fillable = [
        'id',
        'user_id',
        'notification_id',
        'status'
    ];
    public $timestamps = false;
}