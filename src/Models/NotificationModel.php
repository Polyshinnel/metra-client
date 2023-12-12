<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'id',
        'notification_text',
        'notification_type',
        'publish_status',
        'data_create'
    ];
    public $timestamps = false;
}