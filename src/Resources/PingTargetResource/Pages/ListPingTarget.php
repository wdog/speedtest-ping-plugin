<?php

namespace Wdog\Ping\Resources\PingTargetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Wdog\Ping\Resources\PingTargetResource;
use Wdog\Ping\Resources\PingTargetResource\Widgets\PingOverview;

class ListPingTarget extends ListRecords
{
    protected static string $resource = PingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


 
}
