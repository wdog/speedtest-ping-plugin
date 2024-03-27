<?php

namespace Wdog\Ping\Actions;

use App\Events\SpeedtestStarted;
use App\Jobs\Speedtests\ExecuteOoklaSpeedtest;
use App\Models\Result;
use Lorisleiva\Actions\Concerns\AsAction;
use Wdog\Ping\Models\PingTarget;

class RunPingTest
{
    use AsAction;

    public function handle(PingTarget $target, bool $scheduled = false): void
    {
        dump($target);

        $target->results()->create([
            'scheduled' => $scheduled,
            'ping' => 0,
            'data' => $scheduled,
        ]);

        // SpeedtestStarted::dispatch($result);

        // ExecuteOoklaSpeedtest::dispatch(result: $result, serverId: $serverId);
    }
}
