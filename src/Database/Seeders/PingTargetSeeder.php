<?php

namespace Wdog\Ping\Database\Seeders;

use Illuminate\Database\Seeder;
use Wdog\Ping\Models\PingTarget;

class PingTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['target_name' => 'TEST 1', 'target_ip' => '1.1.1.1', 'target_schedule' => '*/1 * *  * *'],
            ['target_name' => 'TEST 2', 'target_ip' => '8.8.8.8', 'target_schedule' => '*/2 * * * *'],
            ['target_name' => 'TEST 3', 'target_ip' => '8.8.4.4', 'target_schedule' => '*/3 * * * *'],
            ['target_name' => 'TEST 4', 'target_ip' => '127.0.0.1', 'target_schedule' => '*/4 * * * *'],
        ];

        foreach ($data as $d) {
            PingTarget::create($d);
        }
    }
}
