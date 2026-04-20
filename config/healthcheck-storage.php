<?php

declare(strict_types=1);

return [
    /*
     * The disks to monitor for writability.
     */
    'disks' => explode(',', env('HEALTH_STORAGE_DISKS', 'local,public')),
];
