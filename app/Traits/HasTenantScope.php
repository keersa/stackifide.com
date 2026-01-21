<?php

namespace App\Traits;

use App\Helpers\TenantHelper;
use Illuminate\Database\Eloquent\Builder;

trait HasTenantScope
{
    /**
     * Boot the trait.
     */
    protected static function bootHasTenantScope(): void
    {
        // Automatically scope queries to the current tenant
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (TenantHelper::isTenantSite()) {
                $builder->where('tenant_id', TenantHelper::id());
            }
        });
        
        // Automatically set tenant_id when creating a new model
        static::creating(function ($model) {
            if (TenantHelper::isTenantSite() && !isset($model->tenant_id)) {
                $model->tenant_id = TenantHelper::id();
            }
        });
    }
    
    /**
     * Scope a query to include all tenants (bypass the global scope).
     */
    public function scopeAllTenants(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
    
    /**
     * Get the tenant that owns this model.
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}
