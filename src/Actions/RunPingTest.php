<?php

namespace Wdog\Ping\Actions;

use App\Enums\ResultStatus;
use App\Events\SpeedtestStarted;
use App\Jobs\Speedtests\ExecuteOoklaSpeedtest;
use App\Models\Result;
use Lorisleiva\Actions\Concerns\AsAction;
use Wdog\Ping\Models\PingTarget;

class RunPingTest
{
    use AsAction;

    public function handle(PingTarget $target): void
    {

        $result = $target->results()->create([
            'status' => ResultStatus::Started,
            'ping' => 0,
            'data' => [],
        ]);

        $ping = new \JJG\Ping($target->target_ip);
        $latency = $ping->ping();
        if ($latency !== false) {
            $result->ping = $latency;
            $result->status = ResultStatus::Completed;
        } else {
            // $result->data = ['error' => 'target unreachable'];
            $result->data = ['error' => $ping->getCommandOutput()];
            $result->status = ResultStatus::Failed;
        }
        $result->save();

        // SpeedtestStarted::dispatch($result);

        // ExecuteOoklaSpeedtest::dispatch(result: $result, serverId: $serverId);
    }
}
