<?php
declare(strict_types=1);

use \App\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class UserMigration extends Migration
{
    public function up(){
        $exists = $this->hasTable('users');

        if(!$exists) {
            $this->schema->create('users', function (Blueprint $table){
                $table->increments('id');
                $table->string('name','128');
                $table->string('inn','15');
                $table->string('org_name', '128');
                $table->string('org_addr','256');
                $table->string('mail', '128');
                $table->string('phone', '20');
                $table->string('country', '4');
                $table->string('password', '256');
                $table->integer('status');
                $table->string('restore_token', '64');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
