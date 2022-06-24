<?php

namespace Spatie\SidecarShiki;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\SidecarShiki\Commands\InternalShikiSetupCommand;

class SidecarShikiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('sidecar-shiki')
            ->hasCommand(InternalShikiSetupCommand::class)
            ->hasConfigFile();
    }
}
