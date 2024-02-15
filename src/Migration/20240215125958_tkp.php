<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Tkp extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp');

        if(!$exists) {
            $this->schema->create('tkp', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->string('path', 128);
                $table->integer('category_id')->unsigned();

                $table->foreign('category_id')->references('id')->on('tkp_categories');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp');
    }
}
