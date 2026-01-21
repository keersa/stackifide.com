<?php

namespace App\Traits;

use App\Helpers\WebsiteHelper;
use Illuminate\Database\Eloquent\Builder;

trait HasWebsiteScope
{
    /**
     * Boot the trait.
     */
    protected static function bootHasWebsiteScope(): void
    {
        // Automatically scope queries to the current website
        static::addGlobalScope('website', function (Builder $builder) {
            if (WebsiteHelper::isWebsiteSite()) {
                $builder->where('website_id', WebsiteHelper::id());
            }
        });
        
        // Automatically set website_id when creating a new model
        static::creating(function ($model) {
            if (WebsiteHelper::isWebsiteSite() && !isset($model->website_id)) {
                $model->website_id = WebsiteHelper::id();
            }
        });
    }
    
    /**
     * Scope a query to include all websites (bypass the global scope).
     */
    public function scopeAllWebsites(Builder $query): Builder
    {
        return $query->withoutGlobalScope('website');
    }
    
    /**
     * Get the website that owns this model.
     */
    public function website()
    {
        return $this->belongsTo(\App\Models\Website::class);
    }
}
