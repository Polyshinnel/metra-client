<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'id',
        'notification_title',
        'notification_text',
        'notification_type',
        'publish_status',
        'date_create',
        'date_publish'
    ];
    public $timestamps = false;
}