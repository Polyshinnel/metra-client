<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TkpChars extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp_chars');

        if(!$exists) {
            $this->schema->create('tkp_chars', function (Blueprint $table){
                $table->increments('id');
                $table->integer('tkp_id')->unsigned();
                $table->integer('tkp_param_id')->unsigned();
                $table->string('value');

                $table->foreign('tkp_id')->references('id')->on('tkp');
                $table->foreign('tkp_param_id')->references('id')->on('tkp_params');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp_chars');
    }
}
