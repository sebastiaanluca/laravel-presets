<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Analytics;

use Analytics\Enums\TrackingCodes;
use Analytics\Models\Activity;
use Tests\Feature\FeatureTestCase;

class ActivityTrackerQueryTest extends FeatureTestCase
{
    /**
     * @test
     */
    public function an activity can be retrieved by its tracking code() : void
    {
        $activity = factory(Activity::class)->create([
            'tracking_code' => TrackingCodes::DISCOUNT_CODE_USED,
        ]);

        $queriedActivity = Activity::query()
            ->usingTrackingCode(TrackingCodes::DISCOUNT_CODE_USED)
            ->first();

        $this->assertSame($activity->tracking_code, $queriedActivity->tracking_code);
        $this->assertSame($activity->id, $queriedActivity->id);
    }

    /**
     * @test
     */
    public function multiple activities can be retrieved by their tracking codes() : void
    {
        $activities = factory(Activity::class)->times(3)->create([
            'tracking_code' => TrackingCodes::DISCOUNT_CODE_USED,
        ]);

        $queriedActivities = Activity::query()
            ->usingTrackingCode(TrackingCodes::DISCOUNT_CODE_USED)
            ->get();

        $this->assertSameValues($activities->pluck('tracking_code'), $queriedActivities->pluck('tracking_code'));
        $this->assertSameValues($activities->pluck('id'), $queriedActivities->pluck('id'));
    }

    /**
     * @test
     */
    public function an activity can be retrieved by its tag() : void
    {
        $activity = factory(Activity::class)->create([
            'properties' => [
                'tags' => [
                    'shop',
                    'order',
                    'user',
                ],
            ],
        ]);

        $queriedActivity = Activity::query()
            ->usingTag('order')
            ->first();

        $this->assertSame($activity->id, $queriedActivity->id);
    }

    /**
     * @test
     */
    public function activities can be retrieved by their tags() : void
    {
        $activities = [];

        $activities[] = Activity::start()
            ->withTags('order')
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $activities[] = Activity::start()
            ->withTags('shop')
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $activities[] = Activity::start()
            ->withTags('user')
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $queriedActivities = Activity::query()
            ->usingTags(['order', 'shop', 'user'])
            ->get();

        $this->assertSameValues(collect($activities)->pluck('id'), $queriedActivities->pluck('id'));
    }
}
