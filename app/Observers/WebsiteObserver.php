<?php

namespace App\Observers;

use App\Models\Website;
use App\Actions\LogAction;

class WebsiteObserver
{
    /**
     * Handle the Website "created" event.
     */
    public function created(Website $website): void
    {
        app(LogAction::class)->logCreate($website);
    }

    /**
     * Handle the Website "updated" event.
     */
    public function updated(Website $website): void
    {
        // getOriginal() still contains the original values in the updated event
        app(LogAction::class)->logUpdate($website);
    }

    /**
     * Handle the Website "deleted" event.
     */
    public function deleted(Website $website): void
    {
        app(LogAction::class)->logDelete($website);
    }

    /**
     * Handle the Website "restored" event.
     */
    public function restored(Website $website): void
    {
        // Log restoration as an update
        app(LogAction::class)->execute('website.restored', $website);
    }

    /**
     * Handle the Website "force deleted" event.
     */
    public function forceDeleted(Website $website): void
    {
        app(LogAction::class)->execute('website.force_deleted', $website);
    }
}
