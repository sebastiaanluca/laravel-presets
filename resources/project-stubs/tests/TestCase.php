<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\CreatesApplication;
use Tests\Concerns\FakesFacades;
use Tests\Concerns\HandlesPermissions;
use Tests\Concerns\MocksExternalCalls;
use Tests\Concerns\MocksInstances;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MocksInstances, FakesFacades, MocksExternalCalls;
    use HandlesPermissions;

    /**
     * Assert each item in a collection is equal to the given value.
     *
     * @param iterable $array
     * @param mixed $value
     */
    public static function assertEachEquals(iterable $array, $value) : void
    {
        foreach ($array as $item) {
            static::assertEquals($value, $item);
        }
    }

    /**
     * Assert each item in a collection is the given value.
     *
     * @param iterable $array
     * @param mixed $value
     */
    public static function assertEachSame(iterable $array, $value) : void
    {
        foreach ($array as $item) {
            static::assertSame($value, $item);
        }
    }

    /**
     * Asserts that two variables are equal regardless of their order.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    public static function assertSameValues($expected, $actual, string $message = '') : void
    {
        static::assertEqualsCanonicalizing(
            $expected,
            $actual,
            $message
        );
    }

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits() : array
    {
        $uses = parent::setUpTraits();

        foreach ($uses as $trait => $flippedIndex) {
            if (method_exists($this, $method = 'setUp' . class_basename($trait))) {
                $this->$method();
            }
        }

        return $uses;
    }

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }
}
