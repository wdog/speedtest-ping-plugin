<?php

namespace Wdog\Ping\Resources\PingTargetResource\Widgets;

use Wdog\Ping\Models\PingResult;
use Wdog\Ping\Models\PingTarget;
use Illuminate\Support\Facades\Log;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{

    public ?PingTarget $record;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $pollingInterval = '10s';

    protected $listeners = [
        'refreshPing' => '$refresh'
    ];

    protected function getCards(): array
    {


        $latest_result = $this->record->results()
            ->select(['id', 'ping',  'created_at'])
            ->latest()
            ->first();

        /** if no ping result */    
        if (blank($latest_result)) {
            return [
                Stat::make('Latest ping', '-')
                    ->icon('heroicon-o-clock'),
                Stat::make('Ping Count', 0)
                    ->color('success')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->description("ping")
            ];
        }

        /** if only one ping result  */
        $previous = $this->record->results()
            ->select(['id', 'ping', 'created_at'])
            ->where('id', '<', $latest_result->id)
            ->latest()
            ->first();

        if (!$previous) {
            return [
                Stat::make(
                    'Latest ping',
                    fn (): string => !blank($latest_result) ?
                        number_format($latest_result->ping, 2) . ' ms' : 'n/a'
                )
                    ->icon('heroicon-o-clock'),

                Stat::make('Ping Count', 1)
                    ->color('success')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->description("ping")
            ];
        }

        /** if more than one ping show percent change */
        $pingChange = percentChange($latest_result->ping, $previous->ping, 2);

        return [

            Stat::make('Latest ping', fn (): string => !blank($latest_result) ? number_format($latest_result->ping, 2) . ' ms' : 'n/a')
                ->icon('heroicon-o-clock')
                ->description($pingChange > 0 ? $pingChange . '% slower' : abs($pingChange) . '% faster ')
                ->descriptionIcon($pingChange > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($pingChange > 0 ? 'danger' : 'success'),

            Stat::make('Ping Count', $this->record->results()->count())
                ->color('success')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->description("ping " )

        ];
    }


    public function getColumns(): int
    {
        return 2;
    }
}
