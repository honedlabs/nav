<?php

declare(strict_types=1);

namespace Honed\Nav\Tests\Stubs;

enum Status: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case COMING_SOON = 'coming-soon';
}
