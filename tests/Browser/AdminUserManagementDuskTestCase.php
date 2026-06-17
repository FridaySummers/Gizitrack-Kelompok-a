<?php

namespace Tests\Browser;

use Tests\Browser\Traits\AdminAccountHelper;
use Tests\DuskTestCase;

abstract class AdminUserManagementDuskTestCase extends DuskTestCase
{
    use AdminAccountHelper;

    protected static bool $databasePrepared = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! static::$databasePrepared) {
            $database = database_path('dusk.sqlite');

            if (! file_exists($database)) {
                touch($database);
            }

            $this->artisan('migrate:fresh');
            static::$databasePrepared = true;
        }
    }
}
