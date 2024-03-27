<?php

namespace Wdog\Ping\Commands;

use Illuminate\Console\Command;

class DemoPingTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Write test log';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        echo \Carbon\Carbon::now();
    }
}
