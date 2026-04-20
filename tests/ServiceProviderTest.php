<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

it('publishes the config file under the correct tag', function () {
    $this->artisan('vendor:publish', [
        '--tag' => 'healthcheck-pgvector-config',
        '--force' => true,
    ])->assertExitCode(0);

    expect(config_path('healthcheck-pgvector.php'))->toBeFile();

    File::delete(config_path('healthcheck-pgvector.php'));
});

it('loads config with the correct default', function () {
    expect(config('healthcheck-pgvector.required'))->toBeFalse();
});

it('loads translations for the installed message', function () {
    expect(trans('healthcheck-pgvector::messages.installed', ['version' => '0.7.0']))
        ->toBe('pgvector extension is installed (version 0.7.0).');
});

it('loads translations for the missing message', function () {
    expect(trans('healthcheck-pgvector::messages.missing'))
        ->toBe('pgvector extension is required but not installed.');
});

it('loads translations for the not_installed message', function () {
    expect(trans('healthcheck-pgvector::messages.not_installed'))
        ->toBe('pgvector extension is not installed.');
});

it('loads translations for the query_failed message', function () {
    expect(trans('healthcheck-pgvector::messages.query_failed', ['message' => 'conn refused']))
        ->toBe('Could not verify pgvector extension: conn refused');
});
