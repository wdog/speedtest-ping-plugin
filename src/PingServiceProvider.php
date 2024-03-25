<?php

namespace Wdog\Ping;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class PingServiceProvider extends PackageServiceProvider
{

    public static string $name = 'ping';
    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasMigration('create_ping_tables')
            ->hasAssets()
            ->hasInstallCommand(function (InstallCommand $command) {                
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }


    


}
