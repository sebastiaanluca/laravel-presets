<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset;

use RuntimeException;

/**
 * @param bool $result
 *
 * @throws \RuntimeException
 */
function handle_filesystem_errors(bool $result) : void
{
    if ($result === true) {
        return;
    }

    throw new RuntimeException('Unable to perform operation.');
}
