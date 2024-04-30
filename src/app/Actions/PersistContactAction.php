<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Contact;

class PersistContactAction
{
    use AsAction;

    protected function persist(array $validated): Contact
    {
        return tap(new Contact($validated), function ($contact) {
            $contact->save();
        });
    }

    public function handle(array $attribs): Contact
    {
        $validated = Validator::validate($attribs, $this->rules());

        return $this->persist($validated);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'middle_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string'],
            'mobile' => ['required', 'string'],
            'addresses' => ['required', 'array'],
            'employment' => ['nullable', 'array'],
            'employment.status' => ['nullable', 'string'],
            'employment.industry' => ['nullable', 'string'],
            'employment.gross_income' => ['nullable', 'string'],
            'employment.nationality' => ['nullable', 'string'],
            'employment.type' => ['nullable', 'string'],
            'employment.current_position' => ['nullable', 'string'],
            'employment.name' => ['nullable', 'string'],
            'employment.contact_number' => ['nullable', 'string'],
            'employment.address' => ['nullable', 'string'],
            'employment.block_lot' => ['nullable', 'string'],
            'employment.street_line2' => ['nullable', 'string'],
            'employment.city' => ['nullable', 'string'],
            'employment.province' => ['nullable', 'string'],
            'employment.zip_code_postal_code' => ['nullable', 'string'],
            'employment.tin_number' => ['nullable', 'string'],
            'employment.pagibig_number' => ['nullable', 'string'],
            'employment.sss_number' => ['nullable', 'string'],
            'co_borrowers' => ['nullable', 'array'],
            'order' => ['nullable', 'array'],
            'order.sku' => ['nullable', 'string'],
            'order.seller_code' => ['nullable', 'string'],
            'order.property_code' => ['nullable', 'string'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $contact = $this->persist($request->validated());

        return response()->json([
            'uid' => $contact->uid,
            'status' => $contact->exists
        ]);
    }
}
