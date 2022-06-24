<?php

return [
    /**
     * Define the allocated memory available to SidecarShiki in megabytes. (Defaults to 2GB).
     * @see https://hammerstone.dev/sidecar/docs/main/functions/customization#memory
     * @see https://github.blog/2021-06-22-framework-building-open-graph-images/
     */
    'memory' => env('SIDECAR_SHIKI_MEMORY', 2048),

    /**
     * Define the number of warming instances to boot.
     * @see https://hammerstone.dev/sidecar/docs/main/functions/warming
     */
    'warming' => env('SIDECAR_SHIKI_WARMING_INSTANCES', 0),
];
