<?php

declare(strict_types=1);

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('source classes use strict types')
    ->expect('IllumaLaw\HealthCheckStorage')
    ->toUseStrictTypes();

arch('check class extends Spatie Check')
    ->expect('IllumaLaw\HealthCheckStorage\StorageDiskWritabilityCheck')
    ->toExtend('Spatie\Health\Checks\Check');

arch('service provider extends PackageServiceProvider')
    ->expect('IllumaLaw\HealthCheckStorage\HealthcheckStorageServiceProvider')
    ->toExtend('Spatie\LaravelPackageTools\PackageServiceProvider');
