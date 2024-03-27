<?php

namespace Wdog\Ping\Resources\PingTargetResource\Widgets;

use Filament\Widgets\ChartWidget;

class PingOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            1,2,3
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
