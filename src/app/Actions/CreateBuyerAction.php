<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Buyer, Voucher};
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Events\BuyerCreated;
use Illuminate\Support\Arr;
use App\Models\User;

class CreateBuyerAction
{
    use AsAction;

    protected function createBuyer(array $attributes): Voucher
    {
        $validated = Validator::validate($attributes, $this->rules());
        $voucher = $this->getVoucher($validated);
        $agent = $this->getSeller($validated);
        $fieldsExtracted = Arr::get($validated, 'body.data.fieldsExtracted');
        $idType = Arr::get($validated, 'body.data.idType');
        $buyer = Buyer::create([
            'name' => Arr::get($fieldsExtracted, 'fullName'),
            'address' => Arr::get($fieldsExtracted, 'address'),
            'birthdate' => Arr::get($fieldsExtracted, 'dateOfBirth'),
//            'mobile' => '09173011987',
            'id_type' => $idType,
            'id_number' => Arr::get($fieldsExtracted, 'idNumber'),
//            'id_image_url' => $this->faker->url(),
//            'selfie_image_url' => $this->faker->url(),
//            'id_mark_url' => $this->faker->url(),
        ]);
        $order = $voucher->getOrder();
        $order->buyer()->associate($buyer);
        $order->save();
        $voucher->save();

        BuyerCreated::dispatch($voucher);

        return $voucher;
    }

    public function handle(array $attributes): Voucher
    {
        return $this->createBuyer($attributes);
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'array'],
            'body.campaign.agent' => ['required', 'array'],
            'body.campaign.agent.name' => ['required', 'string'],
            'body.campaign.agent.email' => ['required', 'email'],
            'body.campaign.agent.mobile' => ['nullable', 'string'],
            'body.inputs' => ['required', 'array'],
            'body.inputs.code' => ['required', 'string'],
            'body.inputs.email' => ['required', 'email'],
            'body.data' => ['required', 'array'],
            'body.data.idType' => ['required', 'string'],
            'body.data.fieldsExtracted' => ['required', 'array'],
            'body.data.fieldsExtracted.fullName' => ['required', 'string'],
            'body.data.fieldsExtracted.dateOfBirth' => ['required', 'date'],
            'body.data.fieldsExtracted.address' => ['required', 'string'],
            'body.data.fieldsExtracted.idNumber' => ['required', 'string'],
        ];
    }
    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $buyer = $this->createBuyer($request->validated());

        return back(302)->with([
            'key' => 'value'
        ]);
    }

    /**
     * TODO: refactor this to an action
     *
     * @param array $attributes
     * @return Voucher
     */
    private function getVoucher(array $attributes): Voucher
    {
        $inputs =  Arr::get($attributes, 'body.inputs');
        $code = Arr::get($inputs, 'code');

        return Voucher::where('code', $code)->firstOrFail();
    }

    private function getSeller(array $attributes): User
    {
        $agent_attributes = Arr::get($attributes, 'body.campaign.agent');
        $email = Arr::get($agent_attributes, 'email');

        return User::where('email', $email)->firstOrFail();
    }
}
