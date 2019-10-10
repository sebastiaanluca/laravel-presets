<?php

declare(strict_types=1);

namespace Modules\Database\Exceptions;

use Exception;

class MigrationException extends Exception
{
    /**
     * @return static
     */
    public static function undoNotSupported() : self
    {
        return new static('A migration cannot be reverted in production environments.');
    }
}
