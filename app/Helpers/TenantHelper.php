<?php

namespace App\Helpers;

use App\Models\Tenant;

class TenantHelper
{
    /**
     * Get the current tenant instance.
     */
    public static function current(): ?Tenant
    {
        try {
            return app()->bound('tenant') ? app('tenant') : null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Check if we're on a tenant site.
     */
    public static function isTenantSite(): bool
    {
        return self::current() !== null;
    }
    
    /**
     * Check if we're on the main site.
     */
    public static function isMainSite(): bool
    {
        return !self::isTenantSite();
    }
    
    /**
     * Get the current tenant ID.
     */
    public static function id(): ?int
    {
        $tenant = self::current();
        return $tenant ? $tenant->id : null;
    }
}
