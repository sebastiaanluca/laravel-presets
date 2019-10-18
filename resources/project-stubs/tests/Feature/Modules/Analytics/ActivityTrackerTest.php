<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Analytics;

use Analytics\Enums\ActivityLogs;
use Analytics\Enums\TrackingCodes;
use Analytics\Enums\TrackingTags;
use Analytics\Models\Activity;
use Store\Models\Users\StoreEmployee;
use Tests\Feature\FeatureTestCase;
use User\Models\User;

class ActivityTrackerTest extends FeatureTestCase
{
    /**
     * @test
     */
    public function an activity can be tracked() : void
    {
        Activity::start()->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());
        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, Activity::query()->first()->tracking_code);
    }

    /**
     * @test
     */
    public function an activity with tags can be tracked() : void
    {
        Activity::start()
            ->withTags(TrackingTags::SHOP, TrackingTags::VISITS)
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());

        $activity = Activity::query()->first();

        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, $activity->tracking_code);
        $this->assertSameValues([TrackingTags::SHOP, TrackingTags::VISITS], $activity->getExtraProperty('tags'));
    }

    /**
     * @test
     */
    public function an extended activity can be tracked() : void
    {
        Activity::start()
            ->causedBy($user = factory(User::class)->create())
            ->performedOn($employee = factory(StoreEmployee::class)->create())
            ->withProperties(['key' => 'value'])
            ->withTags(TrackingTags::SHOP)
            ->inLog(ActivityLogs::SYSTEM)
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());

        $activity = Activity::query()->first();

        $this->assertSame('user', $activity->causer_type);
        $this->assertSame($user->id, $activity->causer_id);
        $this->assertSame('store_employee', $activity->subject_type);
        $this->assertSame($employee->id, $activity->subject_id);
        $this->assertSameValues([TrackingTags::SHOP], $activity->getExtraProperty('tags'));
        $this->assertSame('value', $activity->getExtraProperty('key'));
        $this->assertSame(ActivityLogs::SYSTEM, $activity->log_name);
        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, $activity->tracking_code);
    }

    /**
     * @test
     */
    public function the properties of an activity do not overwrite its tags() : void
    {
        Activity::start()
            ->withTags(TrackingTags::SHOP)
            ->withProperties(['key' => 'value'])
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());

        $activity = Activity::query()->first();

        $this->assertSameValues([TrackingTags::SHOP], $activity->getExtraProperty('tags'));
        $this->assertSame('value', $activity->getExtraProperty('key'));
        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, $activity->tracking_code);
    }

    /**
     * @test
     */
    public function the properties of an activity with tags are merged with its other tags() : void
    {
        Activity::start()
            ->withTags(TrackingTags::SHOP)
            ->withProperties(['tags' => ['tag1', 'tag2']])
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());

        $activity = Activity::query()->first();

        $this->assertSameValues([TrackingTags::SHOP, 'tag1', 'tag2'], $activity->getExtraProperty('tags'));
        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, $activity->tracking_code);
    }

    /**
     * @test
     */
    public function tags are merged with existing tags() : void
    {
        Activity::start()
            ->withProperties(['tags' => ['tag1', 'tag2']])
            ->withTags(TrackingTags::SHOP)
            ->track(TrackingCodes::DISCOUNT_CODE_USED);

        $this->assertSame(1, Activity::query()->count());

        $activity = Activity::query()->first();

        $this->assertSameValues([TrackingTags::SHOP, 'tag1', 'tag2'], $activity->getExtraProperty('tags'));
        $this->assertSame(TrackingCodes::DISCOUNT_CODE_USED, $activity->tracking_code);
    }
}
