<?php

namespace App\Helpers;

use App\Models\Website;

class WebsiteHelper
{
    /**
     * Get the current website instance.
     */
    public static function current(): ?Website
    {
        try {
            return app()->bound('website') ? app('website') : null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Check if we're on a website site.
     */
    public static function isWebsiteSite(): bool
    {
        return self::current() !== null;
    }
    
    /**
     * Check if we're on the main site.
     */
    public static function isMainSite(): bool
    {
        return !self::isWebsiteSite();
    }
    
    /**
     * Get the current website ID.
     */
    public static function id(): ?int
    {
        $website = self::current();
        return $website ? $website->id : null;
    }
}
