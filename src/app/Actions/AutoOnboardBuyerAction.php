<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Models\{Buyer, Inventory, Product, Voucher};

class AutoOnboardBuyerAction extends ProcessBuyerAction
{
    protected Voucher $voucher;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules['body.code' ] = ['required', 'string']; //kwyc-check checkin->code TODO: make this required
        $rules['body.inputs.code' ] = ['nullable', 'string'];

        return $rules;
    }

    protected function afterCreatingBuyerProcessing(Buyer $buyer, array $validated): Voucher
    {
        $inventory = $this->getNextInventory($this->project_code);
        $this->voucher = GenerateVoucherAction::run([
            'sku' => $inventory
                ? $inventory->product->sku
                : $this->getDefaultProduct($this->project_code)->sku,
            'email' => $this->getSeller($validated)->email,
        ]);
        $attribs = [
            'property_code' => $inventory
                ? $inventory->property_code
                : $this->project_code,
            'dp_percent' => 0,
            'dp_months' => 24,
        ];
        $this->voucher->forceFill(['checkin_code' => $validated['body']['code']]);//TODO: validate this, or transform into action
        $this->voucher->save();
        UpdateOrderAction::run($this->voucher, $attribs);

        return parent::afterCreatingBuyerProcessing($buyer, $validated);
    }

    protected function getVoucher(array $attributes): Voucher
    {
        return $this->voucher;
    }

    protected function getNextInventory(string $project_code): ?Inventory
    {
        return Inventory::first(); //TODO: refactor to a separate Action or Class
    }

    protected function getDefaultProduct(string $project_code): Product
    {
        return Product::first(); //TODO: refactor to a separate Action or Class
    }
}
