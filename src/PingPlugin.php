<?php

namespace Wdog\Ping;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Wdog\Ping\Resources\PingTargetResource;

class PingPlugin implements Plugin
{
    public function getId(): string
    {
        return 'wdog-ping';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {

        $panel
            ->resources([
                PingTargetResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
