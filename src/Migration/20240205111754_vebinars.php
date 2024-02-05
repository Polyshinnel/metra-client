<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Vebinars extends Migration
{
    public function up(){
        $exists = $this->hasTable('vebinars');

        if(!$exists) {
            $this->schema->create('vebinars', function (Blueprint $table){
                $table->increments('id');
                $table->string('title', 256);
                $table->string('video_link', 512);
                $table->date('date_create');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('user_notifications');
    }
}
