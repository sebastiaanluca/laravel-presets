<?php

declare(strict_types=1);

namespace Analytics\Enums;

use SebastiaanLuca\PhpHelpers\Classes\Enum;

class ActivityLogs
{
    use Enum;

    /**
     * Logs related to internal system events.
     *
     * @var string
     */
    public const SYSTEM = 'system';

    /**
     * Logs for events triggered by or related to the user.
     *
     * @var string
     */
    public const USER = 'user';

    /**
     * Generic logs for events that do not belong in any other category nor require one.
     *
     * @var string
     */
    public const OTHER = 'other';
}
