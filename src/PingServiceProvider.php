<?php

namespace Wdog\Ping;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Wdog\Ping\Commands\PingTest;

class PingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'ping';

    public function configurePackage(Package $package): void
    {

        $package
            ->name(static::$name)
            ->hasMigration('create_ping_tables')
            ->hasCommand(PingTest::class)
            ->hasAssets()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command            
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }

    public function boot()
    {
        $this->app->booted(function () {
          //  $schedule = app(Schedule::class);
        //    $schedule->command('ping:test')->everyMinute();
        });
    }
}
