<?php

namespace Wdog\Ping;

use Wdog\Ping\Actions\RunPingTest;
use Illuminate\Support\Facades\Log;
use Wdog\Ping\Commands\PingRunCommand;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Console\Scheduling\Schedule;
use Wdog\Ping\Commands\RunScheduledPingTest;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Wdog\Ping\Actions\RunScheduledPingTest as ActionsRunScheduledPingTest;
use Wdog\Ping\Commands\DemoPingTest;

class PingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'ping';

    public function configurePackage(Package $package): void
    {

        $package
            ->name(static::$name)
            ->hasMigration('create_ping_tables')
            ->hasAssets()
            ->hasCommands([ActionsRunScheduledPingTest::class, DemoPingTest::class])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }


    public function bootingPackage()
    {

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('ping:run-scheduled-ping')->everyMinute();
        });
    }
}
