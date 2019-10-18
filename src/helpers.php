<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset;

use Illuminate\Filesystem\Filesystem;
use RuntimeException;

/**
 * @param string|null $key
 *
 * @return array
 */
function project_config(?string $key = null) : array
{
    $key = $key
        ? '.' . $key
        : '';

    return config('preset-sebastiaanluca.project' . $key);
}

/**
 * @param string $directory
 *
 * @return string
 */
function project_stub_path(string $directory = '') : string
{
    return __DIR__ . '/../resources/project-stubs/' . $directory;
}

/**
 * @param string|null $key
 *
 * @return array
 */
function package_config(?string $key = null) : array
{
    $key = $key
        ? '.' . $key
        : '';

    return config('preset-sebastiaanluca.package' . $key);
}

/**
 * @param string $path
 *
 * @throws \RuntimeException
 */
function add_gitkeep_to(string $path) : void
{
    handle_filesystem_errors(
        (new Filesystem)->copy(__DIR__ . '/../resources/.gitkeep', $path . '/.gitkeep')
    );
}

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
