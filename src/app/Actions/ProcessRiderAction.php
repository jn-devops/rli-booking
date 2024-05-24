<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Voucher;

class ProcessRiderAction
{
    use AsAction;

    public function handle(Voucher $voucher): string
    {
        $base_url = 'https://form.jotform.com/241278874334060';
        $buyer = $voucher->getOrder()->buyer;

        return trans(':base_url?referenceCode=:reference_code&email=:email&mobile=:mobile&fullName=:name&fullBirthdate=:birthdate&fullAddress=:address', [
            'base_url' => $base_url,
            'reference_code' => $voucher->code,
            'email' => $buyer->email,
            'mobile' => $buyer->mobile,
            'name' => $buyer->name,
            'fullName' => $buyer->name,
            'birthdate' => (string) $buyer->birthdate,
            'address' => $buyer->address,
        ]);
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function asController(ActionRequest $request, string $checkin_code): \Illuminate\Http\RedirectResponse
    {
        $voucher = Voucher::where('checkin_code', $checkin_code)->firstOrFail();;

        $url = $this->handle($voucher);

        return redirect()->away($url);
    }
}
