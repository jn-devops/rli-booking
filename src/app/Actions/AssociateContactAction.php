<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\ContactAssociated;
use RLI\Booking\Models\{Buyer, Contact};

class AssociateContactAction
{
    use AsAction;

    public function handle(Buyer $buyer, Contact $contact): Buyer
    {
        $buyer->contact()->associate($contact);
        $buyer->save();
        ContactAssociated::dispatch($buyer);

        return $buyer;
    }

    public function asController(Buyer $buyer, Contact $contact): \Illuminate\Http\RedirectResponse
    {
        $this->handle($buyer, $contact);

        return back()->with('message', 'Contact associated.');
    }
}
