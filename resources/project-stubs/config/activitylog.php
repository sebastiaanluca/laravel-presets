<?php

use Analytics\Enums\ActivityLogs;
use Analytics\Models\Activity;

return [

    'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),

    'delete_records_older_than_days' => 365,

    'default_log_name' => ActivityLogs::USER,
    'default_auth_driver' => null,

    'subject_returns_soft_deleted_models' => false,

    'activity_model' => Activity::class,
    'table_name' => 'activity_log',
    'database_connection' => env('ACTIVITY_LOGGER_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),

];
