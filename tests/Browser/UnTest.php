<?php

use Laravel\Dusk\Browser;

it('displays the Laravel text on the home page', function () {
    $this->browse(function ($browser) {
        $browser->visit('/')
                ->assertSee('Laravel');
    });
});