<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Models\{Contact, Inventory, Order, Seller, SellerCommission, Voucher};
use RLI\Booking\Data\FinancialSchemeData;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\Arr;

class OnboardContactAction
{
    use AsAction;

    public function handle(Contact $contact, Inventory $inventory, Seller $seller, SellerCommission $sellerCommission, FinancialSchemeData $financialSchemeData)
    {
        $product = $inventory->product;
        $attribs = [
            'sku' => $product->sku,
            'email' => $sellerCommission->seller->email,
            'contact_uid' => (string) $contact->uid,
        ];
        $voucher = GenerateVoucherAction::run($attribs);
        $voucher = $voucher instanceof Voucher ? $voucher : null;
        $order = $voucher->getOrder();
        $order = $order instanceof Order ? $order : null;
        $order->property_code = $inventory->property_code;
        $order->dp_percent = $financialSchemeData->dp_percent;
        $order->dp_months = $financialSchemeData->dp_months;
        $order->seller()->associate($seller);
        $order->sellerCommission()->associate($sellerCommission);
        $order->save();
        $contact->reference_code = $voucher->code;
        $contact->save();

        return $voucher;
    }

    public function rules(): array
    {
        return [
            'contact_uid' => ['required', 'string'],
            'property_code' => ['required', 'string'], //must exist in inventories
            'seller_email' => ['required', 'email'],
            'seller_commission_code' => ['required', 'string'], //must exist in seller commissions
            'dp_percent' => ['required', 'integer'],
            'dp_months' => ['required', 'integer'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $contact = Contact::where('uid', Arr::get($validated,'contact_uid'))->firstOrFail();
        $inventory = Inventory::where('property_code', Arr::get($validated,'property_code'))->firstOrFail();
        $seller = Seller::where('email', Arr::get($validated,'seller_email'))->firstOrFail();
        $sellerCommission = SellerCommission::where('code', Arr::get($validated,'seller_commission_code'))->firstOrFail();
        $financialSchemeData = new FinancialSchemeData(
            dp_percent: Arr::get($validated,'dp_percent'),
            dp_months: Arr::get($validated,'dp_months')
        );
        $voucher = $this->handle(contact: $contact, inventory: $inventory, seller: $seller, sellerCommission: $sellerCommission, financialSchemeData: $financialSchemeData);
        $params = [
            'voucher' => $voucher->code,
        ];

        return redirect()->route('references.show', [
            'voucher' => $voucher->code
        ])->with('params', $params);
    }
}
