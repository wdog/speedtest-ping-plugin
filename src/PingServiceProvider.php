<?php

namespace Wdog\Ping;

use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Wdog\Ping\Commands\PingRunCommand;

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


    public function packageBooted()
    {
        

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('ping:run')->everyMinute();
        });
    }
}
