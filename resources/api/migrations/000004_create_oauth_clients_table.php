<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create('oauth_clients', static function (Blueprint $table) : void {
            $table->uuid('id')->primary();
            $table->bigInteger('user_id')->index()->nullable();

            $table->string('name');
            $table->string('secret', 100)->nullable();

            $table->text('redirect');

            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');

            $table->timestamps();
        });
    }
}
