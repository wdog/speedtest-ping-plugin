<?php

namespace Wdog\Ping;

use Wdog\Ping\Commands\Install;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class PingServiceProvider extends PackageServiceProvider
{

    public static string $name = 'wdog-ping';
    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasMigration('create_wdog_ping_tables')
            ->runsMigrations(true)
            ->hasCommand(Install::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                echo "INSTALL";
                $command
                    ->publishMigrations()
                    ;
            });
            ;
    }
}
