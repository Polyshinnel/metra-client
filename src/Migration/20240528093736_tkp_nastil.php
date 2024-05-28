<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TkpNastil extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp_nastil');

        if(!$exists) {
            $this->schema->create('tkp_nastil', function (Blueprint $table){
                $table->increments('id');
                $table->integer('tkp_id')->unsigned();
                $table->integer('product_id')->unsigned();

                $table->foreign('tkp_id')->references('id')->on('tkp');
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp_nastil');
    }
}
