<?php

namespace Vittozich\Modulara\Modular\Base\Tests;

use App\Console\Kernel;

abstract class ExistsDbTestCase extends BaseTestCase
{
    protected function getEnvName(): string
    {
        return '.env';
    }

    protected function getConsoleKernelClassName(): string
    {
        return Kernel::class;
    }

}
