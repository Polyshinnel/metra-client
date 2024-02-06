<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class AddMaterialContent extends Migration
{
    public function up(){
        $exists = $this->hasTable('add_material_content');

        if(!$exists) {
            $this->schema->create('add_material_content', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->string('icon', 512);
                $table->integer('category_id');
                $table->string('path', 512);
            });
        }
    }

    public function down()
    {
        $this->schema->drop('add_material_content');
    }
}
