<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class News extends Migration
{
    public function up(){
        $exists = $this->hasTable('news');

        if(!$exists) {
            $this->schema->create('news', function (Blueprint $table){
                $table->increments('id');
                $table->string('news_title', 256);
                $table->string('news_short');
                $table->string('news_img', 512);
                $table->text('news_html');
                $table->date('date_create');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('user_notifications');
    }
}
