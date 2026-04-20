<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckStorage\Tests;

use IllumaLaw\HealthCheckStorage\HealthcheckStorageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Health\HealthServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            HealthServiceProvider::class,
            HealthcheckStorageServiceProvider::class,
        ];
    }
}
