<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wdog\Ping\Models\PingHost;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ping_hosts', function (Blueprint $table) {
            $table->id();
            $table->string('server_host')->nullable();
            $table->string('server_name')->nullable();
            $table->timestamp('created_at')
            ->useCurrent();
        });
        Schema::create('ping_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PingHost::class);
            $table->float('ping', 8, 3);
            $table->boolean('scheduled')->default(false);
            $table->json('data'); // is a dump of the cli output in case we want more fields later
            $table->timestamp('created_at')
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ping_results');
        Schema::dropIfExists('ping_hosts');
        
    }
};
