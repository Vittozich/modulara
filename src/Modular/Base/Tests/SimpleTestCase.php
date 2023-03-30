<?php

namespace Vittozich\Modulara\Modular\Base\Tests;

use App\Console\Kernel;
use Vittozich\Modulara\Modular\Core\CoreTestCase;

abstract class SimpleTestCase extends CoreTestCase
{
    protected function getEnvName(): string
    {
        return '.env.testing';
    }

    protected function getConsoleKernelClassName(): string
    {
        return Kernel::class;
    }

}
