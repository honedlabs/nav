<?php

declare(strict_types=1);

use Honed\Nav\NavServiceProvider;

it('publishes config', function () {
    $this->artisan('vendor:publish', ['--provider' => NavServiceProvider::class])
        ->assertSuccessful();

    expect(file_exists(base_path('config/nav.php')))->toBeTrue();
});


