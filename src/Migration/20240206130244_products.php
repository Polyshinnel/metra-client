<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Products extends Migration
{
    public function up(){
        $exists = $this->hasTable('products');

        if(!$exists) {
            $this->schema->create('products', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
                $table->string('img', 512);
                $table->string('sku', 64);
                $table->decimal('price', 10, 2);
                $table->decimal('export_price', 10, 2);
                $table->integer('category_id');
                $table->text('description');
                $table->boolean('status');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('products');
    }
}
