<?php

declare(strict_types=1);

namespace Analytics\Enums;

use SebastiaanLuca\PhpHelpers\Classes\Enum;

class TrackingTags
{
    use Enum;

    /**
     * @var string
     */
    public const SCORES = 'scores';

    /**
     * @var string
     */
    public const VISITS = 'visits';

    /**
     * @var string
     */
    public const SHOP = 'shop';
}
