<?php

namespace Wdog\Ping\Resources\PingTargetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Wdog\Ping\Resources\PingTargetResource;

class EditPingTarget extends EditRecord
{
    protected static string $resource = PingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
