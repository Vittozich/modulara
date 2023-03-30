<?php

namespace Vittozich\Modulara\Modular\Core;

use Illuminate\Foundation\Testing\TestCase;

abstract class CoreTestCase extends TestCase
{
    public function createApplication()
    {
        $app = require getcwd() . '/bootstrap/app.php';
//        $app = require __DIR__ . '/../../../../bootstrap/app.php'; if doesn't work method above
        $app->loadEnvironmentFrom($this->getEnvName());
        $app->make($this->getConsoleKernelClassName())->bootstrap();
        return $app;
    }

    /**
     * return the '.env.testing'; or .env.testing'; or else .env file
     *
     * @return string
     */
    protected abstract function getEnvName(): string;

    /**
     * return Kernel::class; Kernel for console from the app or framework or core of modular
     *
     * @return string
     */
    protected abstract function getConsoleKernelClassName(): string;

}
