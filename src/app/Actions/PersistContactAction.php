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
            'addresses.*.type' => ['required', 'string'],
            'addresses.*.ownership' => ['required', 'string'],
            'addresses.*.address1' => ['required', 'string'],
            'addresses.*.address2' => ['nullable', 'string'],
            'addresses.*.sublocality' => ['nullable', 'string'],
            'addresses.*.locality' => ['required', 'string'],
            'addresses.*.administrative_area' => ['nullable', 'string'],
            'addresses.*.postal_code' => ['nullable', 'string'],
            'addresses.*.sorting_code' => ['nullable', 'string'],
            'addresses.*.country' => ['required', 'string'],

            'spouse' => ['nullable', 'array'],
            'spouse.first_name' => ['required_with:spouse', 'string'],
            'spouse.middle_name' => ['required_with:spouse', 'string'],
            'spouse.last_name' => ['required_with:spouse', 'string'],
            'spouse.civil_status' => ['required_with:spouse', 'string'],
            'spouse.sex' => ['required_with:spouse', 'string'],
            'spouse.nationality' => ['required_with:spouse', 'string'],
            'spouse.date_of_birth' => ['required_with:spouse', 'string'],
            'spouse.email' => ['required_with:spouse', 'string'],
            'spouse.mobile' => ['required_with:spouse', 'string'],

            'employment' => ['nullable', 'array'],
            'employment.employment_status' => ['required_with:employment', 'string'],
            'employment.monthly_gross_income' => ['required_with:employment', 'string'],
            'employment.current_position' => ['required_with:employment', 'string'],
            'employment.employment_type' => ['required_with:employment', 'string'],
            'employment.employer' => ['required_with:employment', 'array'],
            'employment.employer.name' => ['required_with:employment.employer', 'string'],
            'employment.employer.industry' => ['required_with:employment.employer', 'string'],
            'employment.employer.nationality' => ['required_with:employment.employer', 'string'],
            'employment.employer.address' => ['required_with:employment.employer', 'array'],
            'employment.employer.address.type' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.address.ownership' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.address.address1' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.address.locality' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.address.postal_code' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.address.country' => ['required_with:employment.employer.address', 'string'],
            'employment.employer.contact_no' => ['required_with:employment.employer', 'string'],
            'employment.id' => ['required', 'array'],
            'employment.id.tin' => ['required_without_all:employment.id.pag-ibig,employment.id.sss,employment.id.gsis', 'string'],
            'employment.id.pag-ibig' => ['required_without_all:employment.id.tin,employment.id.sss,employment.id.gsis', 'string'],
            'employment.id.sss' => ['required_without_all:employment.id.tin,employment.id.pag-ibig,employment.id.gsis', 'string'],
            'employment.id.gsis' => ['required_without_all:employment.id.tin,employment.id.pag-ibig,employment.id.sss', 'string'],

            'co_borrowers' => ['nullable', 'array'],
            'co_borrowers.*.first_name' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.middle_name' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.last_name' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.civil_status' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.sex' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.nationality' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.date_of_birth' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.email' => ['required_with:co_borrowers', 'string'],
            'co_borrowers.*.mobile' => ['required_with:co_borrowers', 'string'],

            'order' => ['nullable', 'array'],
            'order.sku' => ['nullable', 'string'],
            'order.seller_code' => ['nullable', 'string'],
            'order.property_code' => ['nullable', 'string'],
        ];
    }

    public function asController(ActionRequest $request)
    {
        $contact = $this->persist($request->validated());

        return response()->json([
            'uid' => $contact->uid,
            'status' => $contact->exists
        ]);
    }
}
