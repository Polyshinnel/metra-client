<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class AcademyPages extends Migration
{
    public function up(){
        $exists = $this->hasTable('academy_pages');

        if(!$exists) {
            $this->schema->create('academy_pages', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->text('html');
                $table->string('path', 128);
            });
        }
    }

    public function down()
    {
        $this->schema->drop('academy_pages');
    }
}
