<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Website extends Model
{
    use SoftDeletes;

    protected $table = 'websites';

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'logo_rect',
        'slug',
        'domain',
        'subdomain',
        'status',
        'plan',
        'settings',
        'contact_info',
        'description',
        'timezone',
        'trial_ends_at',
        'subscription_ends_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'contact_info' => 'array',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    /**
     * Get the user (admin/super_admin) that owns this website.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if website is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if website is on trial.
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' || 
               ($this->trial_ends_at && $this->trial_ends_at->isFuture());
    }

    /**
     * Get the full domain for this website.
     */
    public function getFullDomainAttribute(): string
    {
        if ($this->domain) {
            return $this->domain;
        }
        
        if ($this->subdomain) {
            return $this->subdomain . '.' . config('app.domain', 'stackifide.com');
        }
        
        return $this->slug . '.' . config('app.domain', 'stackifide.com');
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        return \Illuminate\Support\Facades\Storage::disk('s3')->url($this->logo);
    }

    /**
     * Get the rectangular logo URL.
     */
    public function getLogoRectUrlAttribute(): ?string
    {
        if (!$this->logo_rect) {
            return null;
        }

        if (str_starts_with($this->logo_rect, 'http')) {
            return $this->logo_rect;
        }

        return \Illuminate\Support\Facades\Storage::disk('s3')->url($this->logo_rect);
    }
}
