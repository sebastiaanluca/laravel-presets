<?php

declare(strict_types=1);

namespace Analytics\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class ActivityTrackingListener implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';
}
