<?php

namespace Wdog\Ping\Resources\PingTargetResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Wdog\Ping\Resources\PingTargetResource;
use Wdog\Ping\Resources\PingTargetResource\Widgets\PingOverview;
use Wdog\Ping\Resources\PingTargetResource\Widgets\StatsOverviewWidget;

class ViewPingTarget extends ViewRecord
{
    protected $listeners = [
        'refreshPing' => '$refresh',
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

    public function getTitle(): string|Htmlable
    {
        return 'Target '.$this->record->target_ip;
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

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Target Info')->schema([
                \Filament\Infolists\Components\TextEntry::make('target_name')->label('Name'),
                \Filament\Infolists\Components\TextEntry::make('target_ip')->label('IP Address'),
                \Filament\Infolists\Components\TextEntry::make('target_schedule')->label('Scheduled Every'),
            ])->columns(3),
        ]);
    }
}
