<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Database\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        $this->schema()->create(config('activitylog.table_name'), static function (Blueprint $table) : void {
            $table->bigIncrements('id');

            $table->nullableMorphs('causer');
            $table->nullableMorphs('subject');

            $table->string('log_name')->nullable()->index();
            $table->string('tracking_code')->nullable()->index();
            $table->text('description')->nullable();
            $table->json('properties')->nullable();

            $table->timestamps();
        });
    }
}
