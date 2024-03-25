<?php

namespace Wdog\Ping;

use Filament\Facades\Filament;
use Wdog\Ping\Commands\Install;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPackageTools\Package;
use Filament\Navigation\NavigationGroup;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Wdog\Ping\Models\PingTargetet;

class PingServiceProvider extends PackageServiceProvider
{

    public static string $name = 'ping';
    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasMigration('create_ping_tables')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }


    


}
