<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create('oauth_personal_access_clients', static function (Blueprint $table) : void {
            $table->increments('id');
            $table->uuid('client_id')->index();

            $table->timestamps();
        });
    }
}
