<?php

namespace Wdog\Ping;

use Illuminate\Support\Facades\Log;
use Wdog\Ping\Commands\PingRunCommand;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Console\Scheduling\Schedule;
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
            ->hasCommand(PingRunCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }


    public function bootingPackage()
    {

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('ping:run')->everyMinute();
        });
    }

   
}
