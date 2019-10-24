<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateOauthAuthCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create('oauth_auth_codes', static function (Blueprint $table) : void {
            $table->string('id', 100)->primary();
            $table->bigInteger('user_id');
            $table->uuid('client_id');

            $table->text('scopes')->nullable();

            $table->boolean('revoked');

            $table->dateTime('expires_at')->nullable();
        });
    }
}
