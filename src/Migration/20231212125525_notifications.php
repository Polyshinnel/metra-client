<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Notifications extends Migration
{
    public function up(){
        $exists = $this->hasTable('notifications');

        if(!$exists) {
            $this->schema->create('notifications', function (Blueprint $table){
                $table->increments('id');
                $table->text('notification_title');
                $table->text('notification_text');
                $table->integer('notification_type');
                $table->integer('publish_status');
                $table->dateTime('date_create');
                $table->dateTime('date_publish');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('notifications');
    }
}
