<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TkpCategories extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp_categories');

        if(!$exists) {
            $this->schema->create('tkp_categories', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->string('img', 256);
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp_categories');
    }
}
