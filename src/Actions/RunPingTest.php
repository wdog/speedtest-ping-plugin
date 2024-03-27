<?php

namespace Wdog\Ping\Actions;

use App\Models\Result;
use App\Events\SpeedtestStarted;
use Wdog\Ping\Models\PingTarget;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Jobs\Speedtests\ExecuteOoklaSpeedtest;

class RunPingTest
{
    use AsAction;

    public function handle(PingTarget $target, bool $scheduled = false): void
    {

        $result = $target->results()->create([
            'scheduled' => $scheduled,
            'ping' => 0,
            'data' => $scheduled,
        ]);


        $ping = new \JJG\Ping($target->target_ip);
        $latency = $ping->ping();
        if ($latency !== false) {
            $result->ping = $latency;
        } else {
            $result->data = "could not be reached";
        }
        $result->save();
        
        // SpeedtestStarted::dispatch($result);

        // ExecuteOoklaSpeedtest::dispatch(result: $result, serverId: $serverId);
    }
}
