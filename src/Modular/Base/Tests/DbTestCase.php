<?php

namespace Modulizm\Core\Modular\Base\Tests;

use App\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class DbTestCase extends BaseTestCase
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
