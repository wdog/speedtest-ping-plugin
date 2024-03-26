<?php

namespace Wdog\Ping\Models;

use App\Enums\ResultStatus;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class PingResult extends Model
{
    use HasFactory, Prunable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ping',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        // 'status' => ResultStatus::class,
        // 'scheduled' => 'boolean',
    ];

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        $settings = new GeneralSettings();

        return static::where('created_at', '<=', now()->subDays($settings->prune_results_older_than));
    }

    /**
     * Get the result's download jitter in milliseconds.
     */
    protected function errorMessage(): Attribute
    {
        return Attribute::make(
            get: fn () => Arr::get($this->data, 'message', ''),
        );
    }

    public function PingTarget(): BelongsTo
    {
        return $this->belongsTo(PingTarget::class);
    }
}
