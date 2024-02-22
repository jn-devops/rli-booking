<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Actions\Fortify\CreateNewUser;
use RLI\Booking\Traits\ValidateHandle;
use RLI\Booking\Models\Seller;
use Illuminate\Support\Arr;

class RegisterSellerAction

{
    use ValidateHandle;
    use AsAction;

    protected function registerSeller(array $validated): Seller
    {
        $user = app(CreateNewUser::class)->create([
            'name' => Arr::get($validated, 'name'),
            'email' => Arr::get($validated, 'email'),
            'password' => Arr::get($validated, 'password'),
            'password_confirmation' => Arr::get($validated, 'password'),
        ]);
        $seller = Seller::from($user);

        $seller->mobile = Arr::get($validated, 'mobile');
        $seller->personal_email = Arr::get($validated, 'personal_email');
        $seller->save();

        return $seller;
    }

    public function handle(array $attribs): Seller
    {
        return $this->registerSeller($attribs);
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string'],
            'email' => ['required', 'string'],
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'personal_email' => ['required', 'string'],
        ];
    }

    public function AsController(ActionRequest $request)
    {
        $seller = $this->registerSeller($request->validated());

        return response($seller->toData(), 200);
    }
}
