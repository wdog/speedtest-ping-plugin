<?php

namespace Wdog\Ping\Resources\PingTargetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Wdog\Ping\Resources\PingTargetResource;

class ViewPingTarget extends ViewRecord
{
    protected static string $resource = PingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
