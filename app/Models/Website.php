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
        'stripe_id',
        'stripe_subscription_id',
        'stripe_price_id',
        'stripe_status',
        'stripe_trial_ends_at',
        'stripe_ends_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'contact_info' => 'array',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'stripe_trial_ends_at' => 'datetime',
        'stripe_ends_at' => 'datetime',
    ];

    /**
     * Get the user (admin/super_admin) that owns this website.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if website has a current subscription (active or Canceled but still in billing period).
     */
    public function hasCurrentSubscription(): bool
    {
        if (!$this->stripe_subscription_id) {
            return false;
        }
        // Active or trialing = current (case-insensitive for Stripe API variations)
        $status = strtolower((string) ($this->stripe_status ?? ''));
        if (in_array($status, ['active', 'trialing'])) {
            return true;
        }
        // Canceled but still within the paid period: check stripe_ends_at or subscription_ends_at
        $endsAt = $this->stripe_ends_at ?? $this->subscription_ends_at;
        if ($endsAt && $endsAt->isFuture()) {
            return true;
        }
        return false;
    }

    /**
     * Check if website is active.
     * A website is only active when it has a current subscription (including Canceled-but-not-ended).
     */
    public function isActive(): bool
    {
        return $this->hasCurrentSubscription();
    }

    /**
     * Scope: only websites with a current subscription (for routing/public access).
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('stripe_subscription_id')
            ->where(function ($q) {
                $q->whereIn('stripe_status', ['active', 'trialing'])
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('stripe_ends_at')
                         ->where('stripe_ends_at', '>', now());
                  });
            });
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

    /**
     * Get Stripe plan price IDs (sandbox/test mode).
     */
    public static function getStripePriceIds(): array
    {
        return [
            'basic' => config('services.stripe.price_basic', 'price_basic_monthly'),
            'pro' => config('services.stripe.price_pro', 'price_pro_monthly'),
        ];
    }

    /**
     * Get the Stripe price ID for the current plan.
     */
    public function getStripePriceId(): ?string
    {
        $priceIds = self::getStripePriceIds();
        return $priceIds[$this->plan] ?? null;
    }

    /**
     * Check if website has an active Stripe subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->stripe_subscription_id && 
               in_array($this->stripe_status, ['active', 'trialing']);
    }

    /**
     * Check if subscription is Canceled but still active until period end.
     */
    public function isSubscriptionCanceled(): bool
    {
        $status = strtolower((string) ($this->stripe_status ?? ''));
        if ($status !== 'canceled' && $status !== 'Canceled') {
            return false;
        }
        // Canceled and still within the paid period
        $endsAt = $this->stripe_ends_at ?? $this->subscription_ends_at;
        return $endsAt && $endsAt->isFuture();
    }

    /**
     * Check if subscription has Canceled status (regardless of end date).
     * Used to show "Canceled" instead of "Inactive" when end date has not been synced yet.
     */
    public function hasCanceledSubscriptionStatus(): bool
    {
        if (!$this->stripe_subscription_id) {
            return false;
        }
        $status = strtolower((string) ($this->stripe_status ?? ''));
        return $status === 'canceled' || $status === 'Canceled';
    }

    /**
     * Get the subscription expiration date for display (stripe_ends_at or subscription_ends_at).
     */
    public function getSubscriptionExpirationDate(): ?\Carbon\Carbon
    {
        return $this->stripe_ends_at ?? $this->subscription_ends_at;
    }
}
