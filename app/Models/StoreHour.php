<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreHour extends Model
{
    protected $fillable = [
        'website_id',
        'day_of_week',
        'is_closed',
        'opens_at',
        'closes_at',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_closed' => 'boolean',
    ];

    public const DAYS = [
        0 => 'Monday',
        1 => 'Tuesday',
        2 => 'Wednesday',
        3 => 'Thursday',
        4 => 'Friday',
        5 => 'Saturday',
        6 => 'Sunday',
    ];

    /**
     * Display order for UI: Sunday first, then Monday...Saturday.
     *
     * NOTE: We keep the stored `day_of_week` mapping as 0=Mon ... 6=Sun (see DAYS),
     * but present it Sunday-first in views/forms.
     */
    public static function daysSundayFirst(): array
    {
        return [
            6 => self::DAYS[6],
            0 => self::DAYS[0],
            1 => self::DAYS[1],
            2 => self::DAYS[2],
            3 => self::DAYS[3],
            4 => self::DAYS[4],
            5 => self::DAYS[5],
        ];
    }

    public static function dayLabel(int $dayOfWeek): string
    {
        return self::DAYS[$dayOfWeek] ?? 'Unknown';
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}

