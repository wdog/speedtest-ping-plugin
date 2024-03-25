<?php

namespace Wdog\Ping\Models;

use Wdog\Ping\Models\PingResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PingTarget extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_ip',
        'target_name',
        'target_schedule',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];


    public function PingResults(): HasMany
    {
        return $this->hasMany(PingResult::class);
    }
}
