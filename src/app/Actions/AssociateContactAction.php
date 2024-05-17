<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\ContactAssociated;
use RLI\Booking\Models\{Buyer, Contact};
use RLI\Booking\Events\ContactPersisted;
use RLI\Booking\Models\Voucher;

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

    public function asListener(ContactPersisted $contactPersisted): void
    {
        $contact = $contactPersisted->contact;
        $reference_code = $contact->reference_code;
        if ($voucher = Voucher::where('code', $reference_code)->first()) {
            $order = $voucher->getOrder();
            $buyer = $order->buyer;
            $this->handle($buyer, $contact);
        }
    }
}
