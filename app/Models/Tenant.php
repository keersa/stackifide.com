<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'subdomain',
        'status',
        'plan',
        'settings',
        'contact_info',
        'description',
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
     * Get the owner of this tenant.
     */
    public function owner(): HasOne
    {
        return $this->hasOne(TenantOwner::class);
    }

    /**
     * Get all owners for this tenant (in case of multiple owners).
     */
    public function owners(): HasMany
    {
        return $this->hasMany(TenantOwner::class);
    }

    /**
     * Check if tenant is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if tenant is on trial.
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' || 
               ($this->trial_ends_at && $this->trial_ends_at->isFuture());
    }

    /**
     * Get the full domain for this tenant.
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
}
