<?php

namespace Feature;

use RLI\Booking\Models\{Contact, Inventory, Seller, SellerCommission};
use RLI\Booking\Data\FinancialSchemeData;
use Lorisleiva\Actions\Concerns\AsAction;

class OnboardContactAction
{
    use AsAction;

    public function handle(Contact $contact, Inventory $inventory, SellerCommission $sellerCommission, FinancialSchemeData $financialSchemeData)
    {

    }
}
