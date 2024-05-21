<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Contact;

class AttachContactMediaAction
{
    use AsAction;

    public function handle(Contact $contact, array $attribs): Contact
    {
        $contact->update($attribs);
        $contact->save();

        return $contact;
    }

    public function rules(): array
    {
        return Arr::mapWithKeys(app(Contact::class)->getMediaFieldNames(), function (string $mediaFieldName) {
            return [
                $mediaFieldName => ['nullable', 'url']
            ];
        });
    }

    public function asController(string $uid, ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $contact = Contact::where('uid', $uid)->firstOrFail();
        $contact = $this->handle($contact, $request->validated());

        return response()->json([
            'contact' => $contact->toData()
        ]);
    }
}
