<?php

namespace Wdog\Ping;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wdog\Ping\Commands\WdogPingInstall;

class PingServiceProvider extends PackageServiceProvider
{

    public static string $name = 'wdog-ping';
    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasMigration('create_wdog_ping_tables')
            ->hasCommand(Install::class);
    }
}
