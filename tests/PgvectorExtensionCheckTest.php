<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckPgvector\PgvectorExtensionCheck;
use Illuminate\Support\Facades\DB;
use Spatie\Health\Enums\Status;

it('succeeds when pgvector is installed', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->with("select extversion as version from pg_extension where extname = 'vector' limit 1")
        ->andReturn((object) ['version' => '0.5.0']);

    $result = PgvectorExtensionCheck::new()->run();

    expect($result->status)->toEqual(Status::ok())
        ->and($result->shortSummary)->toBe('0.5.0')
        ->and($result->meta['installed_version'])->toBe('0.5.0');
});

it('fails when pgvector is required but not installed', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->andReturn(null);

    $result = PgvectorExtensionCheck::new()
        ->required(true)
        ->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('Missing');
});

it('warns when pgvector is not required and not installed', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->andReturn(null);

    $result = PgvectorExtensionCheck::new()
        ->required(false)
        ->run();

    expect($result->status)->toEqual(Status::warning())
        ->and($result->shortSummary)->toBe('Not installed');
});

it('treats empty string version as not installed', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->andReturn((object) ['version' => '']);

    $result = PgvectorExtensionCheck::new()
        ->required(false)
        ->run();

    expect($result->status)->toEqual(Status::warning())
        ->and($result->shortSummary)->toBe('Not installed');
});

it('treats empty string version as missing when required', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->andReturn((object) ['version' => '']);

    $result = PgvectorExtensionCheck::new()
        ->required(true)
        ->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('Missing');
});

it('fails when query throws exception', function () {
    DB::shouldReceive('selectOne')
        ->once()
        ->andThrow(new Exception('Database error'));

    $result = PgvectorExtensionCheck::new()->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('Query failed')
        ->and($result->notificationMessage)->toContain('Database error');
});

it('uses configuration fallback when required is not explicitly set', function () {
    DB::shouldReceive('selectOne')->andReturn(null);
    config()->set('healthcheck-pgvector.required', true);

    $result = PgvectorExtensionCheck::new()->run();

    expect($result->status)->toEqual(Status::failed())
        ->and($result->shortSummary)->toBe('Missing');
});

it('defaults to warning via config fallback when not required', function () {
    DB::shouldReceive('selectOne')->andReturn(null);
    config()->set('healthcheck-pgvector.required', false);

    $result = PgvectorExtensionCheck::new()->run();

    expect($result->status)->toEqual(Status::warning());
});

it('required() is fluent and returns same instance', function () {
    $check = PgvectorExtensionCheck::new();
    $returned = $check->required(true);

    expect($returned)->toBe($check);
});
