<?php

namespace Wdog\Ping;

use Illuminate\Console\Scheduling\Schedule;
use Wdog\Ping\Commands\PingTest;
use Illuminate\Support\Facades\Log;
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
            ->hasCommand(PingTest::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command            
                    ->publishMigrations()
                    ->askToRunMigrations();
            });

                 
    }


    public function boot()
    {
        

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('ping:run')->everyMinute();
        });
    }


}
