<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class TkpParams extends Migration
{
    public function up(){
        $exists = $this->hasTable('tkp_params');

        if(!$exists) {
            $this->schema->create('tkp_params', function (Blueprint $table){
                $table->increments('id');
                $table->string('name', 128);
            });
        }
    }

    public function down()
    {
        $this->schema->drop('tkp_params');
    }
}
