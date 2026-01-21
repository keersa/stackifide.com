<?php

namespace App\Observers;

use App\Models\Page;
use App\Actions\LogAction;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     */
    public function created(Page $page): void
    {
        app(LogAction::class)->logCreate($page);
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        // getOriginal() still contains the original values in the updated event
        app(LogAction::class)->logUpdate($page);
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        app(LogAction::class)->logDelete($page);
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        // Log restoration as an update
        app(LogAction::class)->execute('page.restored', $page);
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        app(LogAction::class)->execute('page.force_deleted', $page);
    }
}
