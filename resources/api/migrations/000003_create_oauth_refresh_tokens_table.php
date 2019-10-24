<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateOauthRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create('oauth_refresh_tokens', static function (Blueprint $table) : void {
            $table->string('id', 100)->primary();
            $table->string('access_token_id', 100)->index();

            $table->boolean('revoked');

            $table->dateTime('expires_at')->nullable();
        });
    }
}
