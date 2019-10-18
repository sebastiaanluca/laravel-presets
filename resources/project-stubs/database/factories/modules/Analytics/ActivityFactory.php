<?php

declare(strict_types=1);

use Analytics\Enums\ActivityLogs;
use Analytics\Models\Activity;
use Domain\Auth\Models\User;
use Faker\Generator as Faker;

$factory->define(Activity::class, static function (Faker $faker) {
    return [
        'causer_id' => factory(User::class),
        'causer_type' => 'user',

        'subject_id' => null,
        'subject_type' => null,

        'log_name' => ActivityLogs::USER,
        'tracking_code' => null,

        'description' => static function (array $activity) {
            return $activity['tracking_code'] !== null
                ? __('tracking.' . $activity['tracking_code'])
                : null;
        },
        'properties' => null,
    ];
});
