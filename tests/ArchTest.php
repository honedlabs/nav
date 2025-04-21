<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Nav')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Nav\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Nav\Contracts')
    ->toBeInterfaces();

arch('commands')
    ->expect('Honed\Nav\Console\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);
