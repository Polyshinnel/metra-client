<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Banners extends Migration
{
    public function up(){
        $exists = $this->hasTable('banners');

        if(!$exists) {
            $this->schema->create('banners', function (Blueprint $table){
                $table->increments('id');
                $table->string('link', 512);
                $table->string('image', 512);
                $table->string('title', 128);
                $table->string('text', 128);
                $table->string('text_btn', 64);
                $table->integer('order');
                $table->boolean('active');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('banners');
    }
}
