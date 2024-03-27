<?php

namespace Wdog\Ping;

use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wdog\Ping\Actions\RunScheduledPingTest;
use Wdog\Ping\Commands\DemoPingTest;
use Wdog\Ping\Database\Seeders\PingTargetSeeder;

class PingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'ping';

    public function configurePackage(Package $package): void
    {

        $package
            ->name(static::$name)
            ->hasMigration('create_ping_tables')
            ->hasAssets()
            ->hasCommands([RunScheduledPingTest::class, DemoPingTest::class])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Have a great day!');
                        $seeder = new PingTargetSeeder();
                        $seeder->run();
                    });
            });
    }

    public function bootingPackage()
    {

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('ping:run-scheduled-ping')->everyMinute();
        });
    }
}
