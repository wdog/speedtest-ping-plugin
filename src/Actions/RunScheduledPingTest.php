<?php

namespace Wdog\Ping\Actions;

use App\Settings\GeneralSettings;
use Cron\CronExpression;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Wdog\Ping\Models\PingTarget;

class RunScheduledPingTest
{
    use AsAction;

    public string $commandSignature = 'ping:run-scheduled-ping';

    public string $commandDescription = 'Run Ping against Targets';

    public function handle()
    {
        $settings = new GeneralSettings();

        $targets = PingTarget::all();
        foreach ($targets as $target) {
            $cronExpression = new CronExpression($target->target_schedule);
            Storage::disk('local')->append('log.txt', "\n".$target->target_name.' '.$cronExpression);

            if ($cronExpression->isDue(now()->timezone($settings->timezone ?? 'UTC'))) {
                Storage::disk('local')->append('log.txt', 'RUN');
                RunPingTest::run($target);
            } else {
                Storage::disk('local')->append('log.txt', 'NO RUN');
            }
        }
    }
}
