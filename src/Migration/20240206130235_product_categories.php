<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class ProductCategories extends Migration
{
    public function up(){
        $exists = $this->hasTable('product_categories');

        if(!$exists) {
            $this->schema->create('product_categories', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->string('img', 512);
                $table->integer('parent_id');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('product_categories');
    }
}
