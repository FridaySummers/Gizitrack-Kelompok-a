<?php

namespace Tests\Browser\Traits;

use Laravel\Dusk\Browser;

trait AuthHelper
{
    /**
     * Log in via the browser form.
     * Visit /login, type credentials, press LOG IN.
     * No pause needed — subsequent visit() calls wait for pages themselves.
     */
    protected function loginAs(
        Browser $browser,
        string $email,
        string $password,
    ): void {
        $browser
            ->visit("/login")
            ->type("email", $email)
            ->type("password", $password)
            ->press("LOG IN");
    }
}
