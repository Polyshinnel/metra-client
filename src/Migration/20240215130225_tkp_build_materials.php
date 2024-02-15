<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TkpBuildMaterials extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp_build_materials');

        if(!$exists) {
            $this->schema->create('tkp_build_materials', function (Blueprint $table){
                $table->increments('id');
                $table->string('name');
                $table->integer('tkp_id')->unsigned();
                $table->string('path');

                $table->foreign('tkp_id')->references('id')->on('tkp');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp_build_materials');
    }
}
