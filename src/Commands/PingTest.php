<?php

namespace Wdog\Ping\Commands;

use Illuminate\Console\Command;

class PingTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Ping Plugin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo \Carbon\Carbon::now();
    }
}