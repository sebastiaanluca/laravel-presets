<?php

declare(strict_types=1);

namespace Analytics\Models;

use Analytics\ActivityTracker;
use Analytics\Exceptions\TrackingException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Models\Activity as BaseActivityModel;

class Activity extends BaseActivityModel
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'tags',
    ];

    /**
     * @return \Analytics\ActivityTracker
     */
    public static function start() : ActivityTracker
    {
        return app(ActivityTracker::class);
    }

    /**
     * @return array
     */
    public function getTagsAttribute() : array
    {
        return $this->getExtraProperty('tags');
    }

    /**
     * @return string|null
     *
     * @throws \Analytics\Exceptions\TrackingException
     */
    public function getDescriptionAttribute() : ?string
    {
        $code = Arr::get($this->attributes, 'description');

        if ($code === null) {
            return null;
        }

        $key = 'tracking.' . $code;
        $description = __($key);

        // Enforce a readable and localized description for the logged event
        if ($description === $key) {
            throw TrackingException::trackingCodeNotTranslated($code, $key);
        }

        return __('tracking.' . $code);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $tags
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsingTags(Builder $query, array $tags) : Builder
    {
        // Querying JSON columns by "whereIn" isn't supported out-of-the-box,
        // so we have to wrap it in a single where query, then query each tag
        // individually to get matching results.

        return $query->where(function (Builder $query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhereJsonContains('properties->tags', $tag);
            }
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $tag
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsingTag(Builder $query, string $tag) : Builder
    {
        return $query->whereJsonContains('properties->tags', [$tag]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $codes
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsingTrackingCodes(Builder $query, array $codes) : Builder
    {
        return $query->whereIn('tracking_code', $codes);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsingTrackingCode(Builder $query, string $code) : Builder
    {
        return $query->where('tracking_code', $code);
    }
}
