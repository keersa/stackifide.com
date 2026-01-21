<?php

namespace App\Observers;

use App\Models\MenuItem;
use App\Actions\LogAction;

class MenuItemObserver
{
    /**
     * Handle the MenuItem "created" event.
     */
    public function created(MenuItem $menuItem): void
    {
        app(LogAction::class)->logCreate($menuItem);
    }

    /**
     * Handle the MenuItem "updated" event.
     */
    public function updated(MenuItem $menuItem): void
    {
        // getOriginal() still contains the original values in the updated event
        app(LogAction::class)->logUpdate($menuItem);
    }

    /**
     * Handle the MenuItem "deleted" event.
     */
    public function deleted(MenuItem $menuItem): void
    {
        app(LogAction::class)->logDelete($menuItem);
    }

    /**
     * Handle the MenuItem "restored" event.
     */
    public function restored(MenuItem $menuItem): void
    {
        // Log restoration as an update
        app(LogAction::class)->execute('menu_item.restored', $menuItem);
    }

    /**
     * Handle the MenuItem "force deleted" event.
     */
    public function forceDeleted(MenuItem $menuItem): void
    {
        app(LogAction::class)->execute('menu_item.force_deleted', $menuItem);
    }
}
