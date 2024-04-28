<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Seller;

class UpdateSellerBankInformationAction
{
    use AsAction;

    public function update(Seller $seller, array $validated): array
    {
        $seller->update($validated);
        $seller->save();

        return $seller->toData();
    }

    public function handle(Seller $seller, array $attribs): array
    {
        $validated = Validator::validate($attribs, $this->rules());

        return $this->update($seller, $validated);
    }

    public function rules(): array
    {
        return [
            'seller_code' => ['required', 'string', 'unique:users,meta->seller_code'],
            'bank_code' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'account_name' => ['required', 'string'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $seller = Seller::from($request->user());
        $data = $this->update($seller, $validated);

        return back()->with('event', [
            'name' => 'bank_details.updated',
            'data' => $data,
        ]);
    }
}
