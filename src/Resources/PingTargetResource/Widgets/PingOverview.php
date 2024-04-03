<?php

namespace Wdog\Ping\Resources\PingTargetResource\Widgets;

use App\Helpers\TimeZoneHelper;
use App\Settings\GeneralSettings;
use Filament\Widgets\ChartWidget;
use Wdog\Ping\Models\PingTarget;

class PingOverview extends ChartWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static ?string $heading = 'Ping Latency';

    protected static ?string $maxHeight = '250px';

    public ?string $filter = '5m';

    public ?PingTarget $record;

    protected $listeners = [
        'refreshPing' => '$refresh',
    ];

    protected function getFilters(): ?array
    {
        return [
            '5m' => '5 Minutes',
            '1h' => 'Last Hour',
            '24h' => 'Last 24h',
            'week' => 'Last week',
            'month' => 'Last month',
        ];
    }

    protected function getData(): array
    {
        $settings = new GeneralSettings();

        $results = $this->record->results()
            ->select(['id', 'ping', 'created_at'])
            ->when($this->filter == '5m', function ($query) {
                $query->where('created_at', '>=', now()->subMinute(5));
            })
            ->when($this->filter == '1h', function ($query) {
                $query->where('created_at', '>=', now()->subHour(1));
            })
            ->when($this->filter == '24h', function ($query) {
                $query->where('created_at', '>=', now()->subDay());
            })
            ->when($this->filter == 'week', function ($query) {
                $query->where('created_at', '>=', now()->subWeek());
            })
            ->when($this->filter == 'month', function ($query) {
                $query->where('created_at', '>=', now()->subMonth());
            })
            ->orderBy('created_at')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Ping Latency',
                    'data' => $results->map(fn ($item) => ! blank($item->ping) ?
                        $item->ping
                        : 0),
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => '#0ea5e9',
                    'fill' => false,
                    'cubicInterpolationMode' => 'monotone',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $results->map(fn ($item) => $item->created_at->timezone(TimeZoneHelper::displayTimeZone($settings))->format('M d - G:i')),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {

        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'subtitle' => [
                    'display' => true,
                    'text' => $this->record?->target_name,
                ],
            ],
        ];
    }

    protected function getPollingInterval(): ?string
    {
        return config('speedtest.dashboard_polling');
    }
}
