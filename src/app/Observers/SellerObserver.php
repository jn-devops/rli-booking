<?php

namespace RLI\Booking\Observers;

use RLI\Booking\Models\Seller;
use Illuminate\Support\Str;

class SellerObserver
{
    /**
     * Handle the Seller "creating" event.
     */
    public function creating(Seller $seller): void
    {
        $seller->code = Str::orderedUuid()->toString();
    }

    /**
     * Handle the Seller "created" event.
     */
    public function created(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "updated" event.
     */
    public function updated(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "deleted" event.
     */
    public function deleted(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "restored" event.
     */
    public function restored(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     */
    public function forceDeleted(Seller $seller): void
    {
        //
    }
}
