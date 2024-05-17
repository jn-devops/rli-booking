<?php

namespace RLI\Booking\Actions;

use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;
use RLI\Booking\Classes\State\ProcessedPendingConfirmation;
use RLI\Booking\Models\{Buyer, Contact, Seller, Voucher};
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\BuyerProcessed;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\Arr;

class ProcessBuyerAction
{
    use AsAction;

    protected string $project_code;

    /**
     * @param array $validated
     * @param string $project_code
     * @return Voucher
     * @throws CouldNotPerformTransition
     */
    protected function processBuyer(array $validated, string $project_code = ''): Voucher
    {
        $this->project_code = $project_code;
        $buyer = $this->createBuyer($validated);
        $voucher = $this->afterCreatingBuyerProcessing($buyer, $validated);
        BuyerProcessed::dispatch($voucher);

        return $voucher;
    }

    /**
     * @param array $attributes
     * @param string $project_code
     * @return Voucher
     * @throws CouldNotPerformTransition
     */
    public function handle(array $attributes, string $project_code = ''): Voucher
    {
        $validated = Validator::validate($attributes, $this->rules());

        return $this->processBuyer($validated, $project_code);
    }

    /**
     * @return array[]
     */
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
            'body.inputs.mobile' => ['required', 'string', 'min:11'],
            'body.data' => ['required', 'array'],
            'body.data.idType' => ['required', 'string'],
            'body.data.fieldsExtracted' => ['required', 'array'],
            'body.data.fieldsExtracted.fullName' => ['required', 'string'],
            'body.data.fieldsExtracted.dateOfBirth' => ['required', 'date'],
            'body.data.fieldsExtracted.address' => ['required', 'string'],
            'body.data.fieldsExtracted.idNumber' => ['required', 'string'],
            'body.data.idImageUrl' => ['required', 'string'],
            'body.data.selfieImageUrl' => ['required', 'string'],
        ];
    }

    /**
     * @param ActionRequest $request
     * @param string $project_code
     * @return RedirectResponse
     * @throws CouldNotPerformTransition
     */
    public function asController(ActionRequest $request, string $project_code = ''): RedirectResponse
    {
        $voucher = $this->processBuyer($request->validated(), $project_code);

        return back(302)->with([
            'voucher' => $voucher->toData()
        ]);
    }

    /**
     * TODO: refactor this to an action
     *
     * @param array $attributes
     * @return Voucher
     */
    protected function getVoucher(array $attributes): Voucher
    {
        $inputs =  Arr::get($attributes, 'body.inputs');
        $code = Arr::get($inputs, 'code');

        return Voucher::where('code', $code)->firstOrFail();
    }

    /**
     * @param array $validated
     * @return Buyer
     */
    public function createBuyer(array $validated): Buyer
    {
        $fieldsExtracted = Arr::get($validated, 'body.data.fieldsExtracted');
        $email = Arr::get($validated, 'body.inputs.email');
        $mobile = Arr::get($validated, 'body.inputs.mobile');
        $idType = Arr::get($validated, 'body.data.idType');
        $idImageUrl = Arr::get($validated, 'body.data.idImageUrl');
        $selfieImageUrl = Arr::get($validated, 'body.data.selfieImageUrl');

        return app(Buyer::class)->create([
            'name' => Arr::get($fieldsExtracted, 'fullName'),
            'address' => Arr::get($fieldsExtracted, 'address'),
            'birthdate' => Arr::get($fieldsExtracted, 'dateOfBirth'),
            'email' => $email,
            'mobile' => $mobile,
            'id_type' => $idType,
            'id_number' => Arr::get($fieldsExtracted, 'idNumber'),
            'id_image_url' => $idImageUrl,
            'selfie_image_url' => $selfieImageUrl,
        ]);
    }

    /**
     * @param Buyer $buyer
     * @param array $validated
     * @return Voucher
     * @throws CouldNotPerformTransition
     */
    protected function afterCreatingBuyerProcessing(Buyer $buyer, array $validated): Voucher
    {
        optional($this->getContact($validated), function (Contact $contact) use ($buyer) {
            AssociateContactAction::run($buyer, $contact);
        });
        $voucher = $this->getVoucher($validated);
        $order = $voucher->getOrder();
        $order->buyer()->associate($buyer);
        $order->state->transitionTo(ProcessedPendingConfirmation::class); //automatic saving

        return $voucher;
    }

    /**
     * @param array $validated
     * @return Contact|null
     */
    protected function getContact(array $validated): ?Contact
    {
        $reference_code = Arr::get($validated, 'body.inputs.code');

        return Contact::where('reference_code', $reference_code)->first();
    }

    /**
     * @param array $validated
     * @return Seller
     */
    protected function getSeller(array $validated): Seller
    {
        $agent_attributes = Arr::get($validated, 'body.campaign.agent');
        $email = Arr::get($agent_attributes, 'email');

        return Seller::where('email', $email)->firstOrFail();
    }
}
