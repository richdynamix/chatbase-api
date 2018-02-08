<?php

namespace Tests;

use Tests\Helpers\ArrayAssertionHelpers;
use Tests\Helpers\EnsureDatabaseDisconnect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        RefreshDatabase,
        ArrayAssertionHelpers,
        EnsureDatabaseDisconnect;

    /** @return void */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Extend the trait setup.
     *
     * @return void
     */
    protected function setUpTraits(): void
    {
        parent::setUpTraits();
        $this->ensureDatabaseDisconnect(parent::setUpTraits());
    }
}
