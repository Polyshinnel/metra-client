<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class Clients extends Migration
{
    public function up(){
        $exists = $this->hasTable('clients');

        if(!$exists) {
            $this->schema->create('clients', function (Blueprint $table){
                $table->increments('id');
                $table->integer('user_id');
                $table->string('inn', 128);
                $table->string('name', 128);
                $table->string('address', 128);
                $table->string('contact_name', 128);
                $table->string('phone', 128);
            });
        }
    }

    public function down()
    {
        $this->schema->drop('clients');
    }
}
