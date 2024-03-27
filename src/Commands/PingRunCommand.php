<?php

namespace Wdog\Ping\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PingRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Ping against Targets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Storage::disk('local')->append('log.txt', date("Y-m-d H:i:s") . " - COMMAND");

        echo \Carbon\Carbon::now();
    }
}
