<?php

namespace Spatie\SidecarShiki\Functions;

use Hammerstone\Sidecar\LambdaFunction;
use Hammerstone\Sidecar\Package;
use Hammerstone\Sidecar\Runtime;
use Hammerstone\Sidecar\WarmingConfig;

class HighlightFunction extends LambdaFunction
{
    public function handler()
    {
        return 'sidecar.handle';
    }

    public function name()
    {
        return 'Shiki Highlight';
    }

    public function package()
    {
        return Package::make()
            ->setBasePath(__DIR__ . '/../../resources/lambda')
            ->include('*');
    }

    public function runtime()
    {
        return Runtime::NODEJS_16;
    }

    public function memory()
    {
        return config('sidecar-shiki.memory');
    }

    public function warmingConfig()
    {
        return WarmingConfig::instances(config('sidecar-shiki.warming'));
    }
}
