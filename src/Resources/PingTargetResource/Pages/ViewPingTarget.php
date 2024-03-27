<?php

namespace Wdog\Ping\Resources\PingTargetResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\ViewRecord;
use Wdog\Ping\Resources\PingTargetResource;
use Wdog\Ping\Resources\PingTargetResource\Widgets\PingOverview;
use Wdog\Ping\Resources\PingTargetResource\Widgets\StatsOverviewWidget;

class ViewPingTarget extends ViewRecord
{

    protected $listeners = [
        'refreshPing' => '$refresh'
    ];

    protected static string $resource = PingTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil'),

            Action::make('prune')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->action(function () {
                    $this->record?->results()->delete();
                })
                ->after(fn ($livewire) => $livewire->dispatch('refreshPing'))
                ->requiresConfirmation(),


        ];
    }



    protected function getHeaderWidgets(): array
    {
        $this->record->refresh();

        return [
            StatsOverviewWidget::make([$this->record]),
            PingOverview::make([$this->record]),
        ];
    }

    public function getHeaderWidgetsColumns(): int
    {
        return 1;
    }
}
