---
description: Storage disk writability health check for Spatie Laravel Health — write/read/delete cycle, multi-disk
---

# healthcheck-storage

Storage disk writability health check for `spatie/laravel-health`. Performs a full write-read-delete cycle on configured disks.

## Namespace

`IllumaLaw\HealthCheckStorage`

## Key Check

- `StorageDiskWritabilityCheck` — write small temp file, read it back, delete it; reports latency per disk

## Registration

```php
use IllumaLaw\HealthCheckStorage\StorageDiskWritabilityCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    StorageDiskWritabilityCheck::new()
        ->disks(['local', 'public', 's3']), // defaults: ['local', 'public']
]);
```

## Notes

- Monitors multiple disks in a single check instance.
- Reports per-disk write latency in health meta data.
- Returns `failed` if any configured disk is not writable.
