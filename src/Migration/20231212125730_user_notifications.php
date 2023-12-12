<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserNotifications extends Migration
{
    public function up(){
        $exists = $this->hasTable('user_notifications');

        if(!$exists) {
            $this->schema->create('user_notifications', function (Blueprint $table){
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('notification_id');
                $table->integer('status');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('user_notifications');
    }
}
