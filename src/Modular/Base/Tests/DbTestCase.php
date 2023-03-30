<?php

namespace Vittozich\Modulara\Modular\Base\Tests;

use App\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Vittozich\Modulara\Modular\Core\CoreTestCase;

abstract class DbTestCase extends CoreTestCase
{
    use RefreshDatabase;

    protected function getEnvName(): string
    {
        return '.env.testing';
    }

    protected function getConsoleKernelClassName(): string
    {
        return Kernel::class;
    }

}
