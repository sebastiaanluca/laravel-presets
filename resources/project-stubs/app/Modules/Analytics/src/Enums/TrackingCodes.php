<?php

declare(strict_types=1);

namespace Analytics\Enums;

use SebastiaanLuca\PhpHelpers\Classes\Enum;

class TrackingCodes
{
    use Enum;

    /**
     * @var string
     */
    public const DISCOUNT_CODE_USED = 'discount_codes.used';
}
