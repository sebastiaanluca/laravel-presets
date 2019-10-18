<?php

declare(strict_types=1);

namespace Analytics;

use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Contracts\Activity;

class ActivityTracker extends ActivityLogger
{
    /**
     * @param mixed ...$tags
     *
     * @return \Analytics\ActivityTracker
     */
    public function withTags(...$tags) : self
    {
        if ($this->getActivity()->properties === null || ($existingTags = $this->getActivity()->getExtraProperty('tags')) === null) {
            return $this->withProperty('tags', $tags);
        }

        $this->withProperty('tags', array_merge_recursive($existingTags, $tags));

        return $this;
    }

    /**
     * @param \Illuminate\Support\Collection|array $properties
     *
     * @return \Analytics\ActivityTracker
     */
    public function withProperties($properties) : self
    {
        if ($this->getActivity()->properties === null) {
            return parent::withProperties($properties);
        }

        $properties = collect($properties);

        $tags = $this->getActivity()->getExtraProperty('tags');

        if ($tags !== null) {
            $properties = $properties->put(
                'tags',
                array_merge_recursive($properties->get('tags', []), $tags)
            );
        }

        $this->getActivity()->properties = $properties;

        return $this;
    }

    /**
     * @param string $code
     *
     * @return \Spatie\Activitylog\Contracts\Activity
     */
    public function track(string $code) : Activity
    {
        $this->addTrackingCode($code);

        return $this->log($code);
    }

    /**
     * @param string $code
     *
     * @return \Analytics\ActivityTracker
     */
    protected function addTrackingCode(string $code) : self
    {
        return $this->tap(function (Activity $activity) use ($code) : void {
            $activity->tracking_code = $code;
        });
    }
}
