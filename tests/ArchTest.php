<?php

declare(strict_types=1);

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Nav')
    ->toUseStrictTypes();

arch('attributes')
    ->expect('Honed\Nav\Attributes')
    ->toBeClasses();

arch('concerns')
    ->expect('Honed\Nav\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Nav\Contracts')
    ->toBeInterfaces();

arch('facades')
    ->expect('Honed\Nav\Facades')
    ->toExtend('Illuminate\Support\Facades\Facade');
