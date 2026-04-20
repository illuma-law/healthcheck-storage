<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckStorage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class HealthcheckStorageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('healthcheck-storage')
            ->hasConfigFile()
            ->hasTranslations();
    }
}
