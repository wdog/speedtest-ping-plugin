<?php

namespace Wdog\Ping;

use Filament\Panel;
use function Psy\debug;
use Filament\Contracts\Plugin;

use Wdog\Ping\Resources\PingTargetResource;
use Wdog\Ping\Resources\PingTargetetResource;

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
        \Log::debug('REG');
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
