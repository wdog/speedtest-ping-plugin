<?php

namespace Wdog\Ping\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Ping Plugin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo \Carbon\Carbon::now();
    }
}
