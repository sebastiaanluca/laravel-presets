<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateOauthAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create('oauth_access_tokens', static function (Blueprint $table) : void {
            $table->string('id', 100)->primary();
            $table->bigInteger('user_id')->index()->nullable();
            $table->uuid('client_id');

            $table->string('name')->nullable();
            $table->text('scopes')->nullable();

            $table->boolean('revoked');

            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
        });
    }
}
