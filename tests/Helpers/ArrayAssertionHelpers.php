<?php

namespace Tests\Helpers;

use PHPUnit\Framework\Assert as PHPUnit;

trait ArrayAssertionHelpers
{
    /**
     * Assert an array has the specified keys.
     *
     * @param array $keys
     * @param array $array
     * @return void
     */
    public function assertArrayHasKeys(array $keys, array $array)
    {
        collect($keys)->each(function ($key) use ($array) {
            PHPUnit::assertArrayHasKey($key, $array);
        });
    }
}