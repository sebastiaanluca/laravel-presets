<?php

declare(strict_types=1);

namespace Modules\Database\Concerns;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;

trait ManagesDatabase
{
    /**
     * @return \Illuminate\Database\Connection
     */
    protected function database() : Connection
    {
        return app(Connection::class);
    }

    /**
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function schema() : Builder
    {
        return app(Builder::class);
    }
}
