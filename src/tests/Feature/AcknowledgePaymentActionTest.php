<?php

use RLI\Booking\Actions\{AcknowledgePaymentAction, GenerateVoucherAction, ProcessBuyerAction, UpdateOrderAction, InvoiceBuyerAction};
use RLI\Booking\Events\{BuyerInvoiced, PaymentDetailsAcquired, PaymentAcknowledged};
use RLI\Booking\Classes\State\{InvoicedPendingPayment, PaidPendingFulfillment};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Notifications\PaymentConfirmedNotification;
use RLI\Booking\Actions\AcquirePaymentDetailsAction;
use Illuminate\Support\Facades\Notification;
use RLI\Booking\Models\{Product, Voucher};
use Illuminate\Support\Facades\Event;
use RLI\Booking\Seeders\UserSeeder;
use Carbon\Carbon;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    Notification::fake();
    $this->seed(UserSeeder::class);
    Event::fake([PaymentDetailsAcquired::class, BuyerInvoiced::class, PaymentAcknowledged::class]);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('voucher', [
    [
        fn() => tap(GenerateVoucherAction::run(['sku' => Product::factory()->create()->sku]), function ($voucher) {
            $attribs = [
                'property_code' => $this->faker->word,
                'dp_percent' => $this->faker->numberBetween(0,20),
                'dp_months' => $this->faker->numberBetween(0,24)
            ];
            UpdateOrderAction::run($voucher, $attribs);
            $fullName = $this->faker->name();
            $address = $this->faker->address();
            $dateOfBirth = $this->faker->date();
            $idType = 'phl_dl';
            $idNumber = 'ID-123456';

            $code = $voucher->code;
            $order = $voucher->getOrder();
            $json_template = '{"body":{"code":"9b182ba6-842f-4531-9d38-920e5a904358","campaign":{"code":"9b1827c4-f374-443d-97e7-58a28043c6ac","name":"RLI Booking","organization":{"id":5,"name":"Raemulan Lands, Inc.","domain":null,"personal":false,"verified":false},"agent":{"id":3,"name":"Devops","email":":email","mobile":"0917 825 1991"},"filepath":"1\/LATEST-RA.pdf","watermarkFilepath":"watermarked\/LATEST-RA.pdf"},"inputs":{"email":"lester@hurtado.ph","code":":code","location":"[]"},"data":{"status":"success","statusCode":200,"metadata":{"requestId":"1705298657363-81314e88-013f-489e-b257-bbabcac193a0","transactionId":"9b182ba6-842f-4531-9d38-920e5a904358"},"application":{"applicationStatus":"auto_approved","workflowDetails":{"workflowId":"workflow_CyjvX9z","version":1},"modules":{"module_id":{"moduleId":"module_id","attempts":1,"imageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/readId\/2024-01-15\/hgqa2f\/1705281208745-785a7339-f3b8-481d-999b-3efd0a880f28\/image.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRSHZDW3EC%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T060418Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENn%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiEApZmmdGF0%2Bysdj0FCRpVySDR%2BOvsYA2yj8qI%2Bx%2FbQ6eQCIEnJslUuyBV5rtpuTlmlg%2BUoGgjwCv045ldEKYHC8j9QKscFCIL%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjU1Njc2NTI1MzQ3IgxhyiAH%2F%2Bzuy3h2dvIqmwUDzYinICmZCtz%2BHOgRJCW%2BoNXYwGQBowJsoHiajeBMt8dTS1Ilocv5vPlcYECmYPYyIfErZSh2vPr0aFw0QIyO%2F0y6O0RbsD2nU90wwrx2grNyfiX%2Bz%2F5j8LXa0nNHT%2FTJlWYOt3F%2FHOnIaNJaeIi%2FVr3Zvid%2F3NwzaYoPVDsDCiWLhLinlM3cLtGRBbUzHkfxuRLc3BJqUPMWsvlwBSR5KatImc4mmQVMosOJb1rMsYHAtsqfUqeEySukmF4LFVPrFQXVAxmihU7M7ez2xxTJaAxkql47AS%2FnGWncABAdMddMws1vcR6KyshTgrKubfT8h%2BmFaCOmPacnd2Gkx%2BZ4%2FRGBB8AV1B8EpTetfIUWz2CzSmoOpBwIWQ0FF6bQDvTjPNfupX2EUEt4MLKebuPkfcD3dyfI%2BJcBOF4CDkmKARrcYTQJ2J8hdCyzcdz40xjI%2B5pZscDR8Cw8lZWhp8rHoQe2kqL6WBdaUor6CdyJUlK%2FxUENIZDtULc80UtPVpOZ4FvUmtGlcHw2ixPXeMtc12rATlhRGrzNP%2F6Ir1uL3nx4XasMQBnMKz5rRpFtaqDaBTmktMJdFsghefLqbiNRBwqsq9I4jUxlQYsZn4kmFxuBjXCSrrXHYgAxNBLvo22beUp6%2BrqB%2BSHROo3KAck2FKDcuhsoQxfchyNtX%2FJUT12MJ7re93vvKACa8Kg%2BeCjRdrW1ecFUqwGmFdJ9mfM%2F6TgJBOVdEhN2WgW%2F5zcF%2FTDK0YL0pXymnojBYNEsIOJhShaPt%2BaNNGp4N2oDkBPTh72Hs1qNw24XPb6am%2Fi3ov8hafrJAmUOImrREJQvv7OPsH46fU2WCY5PAFWpWkvjzZIR9onqlIImC7tjJTWBqEzZnGA%2FpzcSyOudMJ6Hkq0GOrEBdLF2JCh44TnQLOQVNCGgEs%2BfLeKnketHPRW6oVrJu4eYUDuqwOHLJHsaYJ7cwVjmCJynVE7R%2BDVRMOcvmrd%2B0qZSRnjoR5bklgAgIKSp9LG8bQtrb23tsKcS4l9Mzo5PIfpJxNM8MooI%2F9AyH%2FXntVwyitd3hRidB2dmhAY%2FDWmJY1J1haR%2FWP4P%2FYkLip0pmJ2tqBHmzslCmUsR24aU3DnwsjsD6tWXHh%2FKWaak8ssy&X-Amz-Signature=0d01e41d502e07a0ee7540bd123475597efc7fae4652238e6dfc476704fa7f50&X-Amz-SignedHeaders=host","croppedImageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/readId\/2024-01-15\/hgqa2f\/1705281208745-785a7339-f3b8-481d-999b-3efd0a880f28\/cropped.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRSHZDW3EC%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T060418Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENn%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiEApZmmdGF0%2Bysdj0FCRpVySDR%2BOvsYA2yj8qI%2Bx%2FbQ6eQCIEnJslUuyBV5rtpuTlmlg%2BUoGgjwCv045ldEKYHC8j9QKscFCIL%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjU1Njc2NTI1MzQ3IgxhyiAH%2F%2Bzuy3h2dvIqmwUDzYinICmZCtz%2BHOgRJCW%2BoNXYwGQBowJsoHiajeBMt8dTS1Ilocv5vPlcYECmYPYyIfErZSh2vPr0aFw0QIyO%2F0y6O0RbsD2nU90wwrx2grNyfiX%2Bz%2F5j8LXa0nNHT%2FTJlWYOt3F%2FHOnIaNJaeIi%2FVr3Zvid%2F3NwzaYoPVDsDCiWLhLinlM3cLtGRBbUzHkfxuRLc3BJqUPMWsvlwBSR5KatImc4mmQVMosOJb1rMsYHAtsqfUqeEySukmF4LFVPrFQXVAxmihU7M7ez2xxTJaAxkql47AS%2FnGWncABAdMddMws1vcR6KyshTgrKubfT8h%2BmFaCOmPacnd2Gkx%2BZ4%2FRGBB8AV1B8EpTetfIUWz2CzSmoOpBwIWQ0FF6bQDvTjPNfupX2EUEt4MLKebuPkfcD3dyfI%2BJcBOF4CDkmKARrcYTQJ2J8hdCyzcdz40xjI%2B5pZscDR8Cw8lZWhp8rHoQe2kqL6WBdaUor6CdyJUlK%2FxUENIZDtULc80UtPVpOZ4FvUmtGlcHw2ixPXeMtc12rATlhRGrzNP%2F6Ir1uL3nx4XasMQBnMKz5rRpFtaqDaBTmktMJdFsghefLqbiNRBwqsq9I4jUxlQYsZn4kmFxuBjXCSrrXHYgAxNBLvo22beUp6%2BrqB%2BSHROo3KAck2FKDcuhsoQxfchyNtX%2FJUT12MJ7re93vvKACa8Kg%2BeCjRdrW1ecFUqwGmFdJ9mfM%2F6TgJBOVdEhN2WgW%2F5zcF%2FTDK0YL0pXymnojBYNEsIOJhShaPt%2BaNNGp4N2oDkBPTh72Hs1qNw24XPb6am%2Fi3ov8hafrJAmUOImrREJQvv7OPsH46fU2WCY5PAFWpWkvjzZIR9onqlIImC7tjJTWBqEzZnGA%2FpzcSyOudMJ6Hkq0GOrEBdLF2JCh44TnQLOQVNCGgEs%2BfLeKnketHPRW6oVrJu4eYUDuqwOHLJHsaYJ7cwVjmCJynVE7R%2BDVRMOcvmrd%2B0qZSRnjoR5bklgAgIKSp9LG8bQtrb23tsKcS4l9Mzo5PIfpJxNM8MooI%2F9AyH%2FXntVwyitd3hRidB2dmhAY%2FDWmJY1J1haR%2FWP4P%2FYkLip0pmJ2tqBHmzslCmUsR24aU3DnwsjsD6tWXHh%2FKWaak8ssy&X-Amz-Signature=88b534558a1c904c5ba2f507a42f18472eb3c6b5150da9297b791bf1301aa4b4&X-Amz-SignedHeaders=host","documentSelected":"dl","expectedDocumentSide":"front","apiResponse":{"status":"success","statusCode":200,"metadata":{"requestId":"1705281208745-785a7339-f3b8-481d-999b-3efd0a880f28","transactionId":"9b182ba6-842f-4531-9d38-920e5a904358"},"result":{"details":{"idType":":idType","fieldsExtracted":{"type":null,"idNumber":":idNumber","dateOfIssue":null,"dateOfExpiry":"21-04-2027","countryCode":null,"mrzString":null,"firstName":null,"middleName":null,"lastName":null,"fullName":":fullName","dateOfBirth":":dateOfBirth","address":":address","gender":"M","placeOfBirth":null,"placeOfIssue":null,"yearOfBirth":1070,"age":null,"fatherName":null,"motherName":null,"husbandName":null,"spouseName":null,"nationality":"PHL","homeTown":null},"croppedImageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/readId\/2024-01-15\/hgqa2f\/1705281208745-785a7339-f3b8-481d-999b-3efd0a880f28\/cropped.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRTO2R6L7D%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T011331Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENP%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaDmFwLXNvdXRoZWFzdC0xIkYwRAIgbpY3X208HtcJIMzkEayxfj4rilAWnq5sTuCSGqRNMLwCIDjbS3g0LH2m3e9PhiR7%2FYb0BfNeVNEwpa7ZmQYdPCNCKsoFCHwQARoMNjU1Njc2NTI1MzQ3IgxGQvbq%2FtKgxJ%2FnPsMqpwUbSDWqO4X1IvZHzH9q0TlwuaGIiT3sSv0yt6zQnfVZOndiNJJJOnYxiL2u4u97Q9EaBAJa3AEjwVKJKyZGlbb0%2F95SLYvrRdMg3K6HuaKHe4%2BllqapCKdZxnsR7PbGu12be13KVmlMvH7Fk8vR7iQ%2FeG0k0FO7X%2FSwF%2B%2BNt1vfu3a6od4YElnC1zGm0x21Pp5BEMDkFYOzx6GqbAXXYRGFreCw9dvXI50JdO7qQ1VSnG58MYytcU3LwMWt1%2FYH6PLTVhGVjgRupcKXhZxRX%2BUf2FTjJIyx2FDVM1y1W%2BZ7v0yQN7NwOK38X%2FuFugRiIhQGtYbxojI7s2cyawTm6%2FlHosIyfKdSQu%2F6r0HPuU92%2FEATCiiXRa3o0tD8lUDEquDrUoHylGyvG2N7epzyhlLoA5G75GXS1gPGZmWA5XiDCslWBG6R9NY6PNhl3LqhjLkg9y8P6F6ldHSqxtvSeSf9Tukz7iaw5D2fMwo0knD6LuxqFej4VpaoYH5DSuNfmELueFNNkdD3FBbhqRYROQbOrzvDF57SmuLgKeHbfarI0mlXqy%2B5xUN%2BelhT89Y%2B4FPhNG2z4VpJ%2BUKtoahTjNRLxfaElqnQjipgUbM%2Bggs1%2FhLtIr4QDY5%2BQclRgYCiu1aMukrFNiL808X6JUCgaO6DiEYNm0D64RP7QJizg2S5yqUAvXX71DiMBthmq6ymtVGpmL7S%2BRNSM8iOG5sIpuke2a8GuKuh%2FjP%2FRIIi4JIa3Qi%2B7VjTeZZm7vSAmACh7cdddNBGQQOaHT%2FVFt8g61pIyKGSCm8zP9h9bRGCCClL0vW0ZPH6cauKg85YH%2F%2Busm0zes5VGZmCKBYvI1vqyR5a4FsKzGg6nrXfGxQm7CjYoBwFf%2BDNwouhMJ1umUYSpeVN1g1PCa6iMO%2FjkK0GOrIBOmLdW7qTnmy32QiSky8Q8tUSpojtIh1V4VsDD%2BFswGdEzV39W2ELuKwr1A0IhAFV7fIvFytkkJns0dEv48HVKnSLMRVj556BqhvyP%2FAIC5uv1P2A5rPfuJiEHsio9FnNxRPJYzFp9qsV8M4xeztz58GoYMnfyFzB%2Buz7OQ7RIrpvcggNp0dnd%2BnfJ4UZGKrg3ySMdJFnhO5N2G%2B95ZMqrX3ywoJGFmctvQ9CV8RP2pDN%2Fw%3D%3D&X-Amz-Signature=b70126a0f300d8385e1a72807328e5d1a6aba6e78549e0490e4f30d18f87296a&X-Amz-SignedHeaders=host","qualityChecks":{"blur":"no","glare":"no","blackAndWhite":"no","capturedFromScreen":"no","partialId":"no"},"by":"KwYC Check"},"action":"pass"}}},"module_selfie":{"moduleId":"module_selfie","attempts":1,"imageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/checkLiveness\/2024-01-15\/hgqa2f\/1705281219097-ffe77ccd-5e2f-4bb8-a4b0-25a97ced90fd\/image.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRSHZDW3EC%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T060418Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENn%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiEApZmmdGF0%2Bysdj0FCRpVySDR%2BOvsYA2yj8qI%2Bx%2FbQ6eQCIEnJslUuyBV5rtpuTlmlg%2BUoGgjwCv045ldEKYHC8j9QKscFCIL%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjU1Njc2NTI1MzQ3IgxhyiAH%2F%2Bzuy3h2dvIqmwUDzYinICmZCtz%2BHOgRJCW%2BoNXYwGQBowJsoHiajeBMt8dTS1Ilocv5vPlcYECmYPYyIfErZSh2vPr0aFw0QIyO%2F0y6O0RbsD2nU90wwrx2grNyfiX%2Bz%2F5j8LXa0nNHT%2FTJlWYOt3F%2FHOnIaNJaeIi%2FVr3Zvid%2F3NwzaYoPVDsDCiWLhLinlM3cLtGRBbUzHkfxuRLc3BJqUPMWsvlwBSR5KatImc4mmQVMosOJb1rMsYHAtsqfUqeEySukmF4LFVPrFQXVAxmihU7M7ez2xxTJaAxkql47AS%2FnGWncABAdMddMws1vcR6KyshTgrKubfT8h%2BmFaCOmPacnd2Gkx%2BZ4%2FRGBB8AV1B8EpTetfIUWz2CzSmoOpBwIWQ0FF6bQDvTjPNfupX2EUEt4MLKebuPkfcD3dyfI%2BJcBOF4CDkmKARrcYTQJ2J8hdCyzcdz40xjI%2B5pZscDR8Cw8lZWhp8rHoQe2kqL6WBdaUor6CdyJUlK%2FxUENIZDtULc80UtPVpOZ4FvUmtGlcHw2ixPXeMtc12rATlhRGrzNP%2F6Ir1uL3nx4XasMQBnMKz5rRpFtaqDaBTmktMJdFsghefLqbiNRBwqsq9I4jUxlQYsZn4kmFxuBjXCSrrXHYgAxNBLvo22beUp6%2BrqB%2BSHROo3KAck2FKDcuhsoQxfchyNtX%2FJUT12MJ7re93vvKACa8Kg%2BeCjRdrW1ecFUqwGmFdJ9mfM%2F6TgJBOVdEhN2WgW%2F5zcF%2FTDK0YL0pXymnojBYNEsIOJhShaPt%2BaNNGp4N2oDkBPTh72Hs1qNw24XPb6am%2Fi3ov8hafrJAmUOImrREJQvv7OPsH46fU2WCY5PAFWpWkvjzZIR9onqlIImC7tjJTWBqEzZnGA%2FpzcSyOudMJ6Hkq0GOrEBdLF2JCh44TnQLOQVNCGgEs%2BfLeKnketHPRW6oVrJu4eYUDuqwOHLJHsaYJ7cwVjmCJynVE7R%2BDVRMOcvmrd%2B0qZSRnjoR5bklgAgIKSp9LG8bQtrb23tsKcS4l9Mzo5PIfpJxNM8MooI%2F9AyH%2FXntVwyitd3hRidB2dmhAY%2FDWmJY1J1haR%2FWP4P%2FYkLip0pmJ2tqBHmzslCmUsR24aU3DnwsjsD6tWXHh%2FKWaak8ssy&X-Amz-Signature=a0cc21d66bd0cb200380606a9c6a1820cc08855701ccf3bc07cc7a6903fad755&X-Amz-SignedHeaders=host","apiResponse":{"status":"success","statusCode":200,"metadata":{"requestId":"1705281219097-ffe77ccd-5e2f-4bb8-a4b0-25a97ced90fd","transactionId":"9b182ba6-842f-4531-9d38-920e5a904358"},"result":{"details":{"idType":null,"liveFace":true,"qualityChecks":{"blur":"no","eyesClosed":"no","maskPresent":"no","multipleFaces":"no"},"by":"KwYC Check"},"action":"pass"}}},"module_facematch":{"moduleId":"module_facematch","attempts":1,"apiResponse":{"status":"success","statusCode":200,"metadata":{"requestId":"1705281221762-9c711e0d-0bf0-47b4-b591-87b83969c621","transactionId":"9b182ba6-842f-4531-9d38-920e5a904358"},"result":{"details":{"idType":null,"match":true,"by":"KwYC Check"},"action":"pass"}}}}},"idType":"phl_dl","fieldsExtracted":{"type":null,"idNumber":":idNumber","dateOfIssue":null,"dateOfExpiry":"21-04-2027","countryCode":null,"mrzString":null,"firstName":null,"middleName":null,"lastName":null,"fullName":":fullName","dateOfBirth":":dateOfBirth","address":":address","gender":"M","placeOfBirth":null,"placeOfIssue":null,"yearOfBirth":1070,"age":null,"fatherName":null,"motherName":null,"husbandName":null,"spouseName":null,"nationality":"PHL","homeTown":null},"idImageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/readId\/2024-01-15\/hgqa2f\/1705281208745-785a7339-f3b8-481d-999b-3efd0a880f28\/image.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRSHZDW3EC%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T060418Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENn%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiEApZmmdGF0%2Bysdj0FCRpVySDR%2BOvsYA2yj8qI%2Bx%2FbQ6eQCIEnJslUuyBV5rtpuTlmlg%2BUoGgjwCv045ldEKYHC8j9QKscFCIL%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjU1Njc2NTI1MzQ3IgxhyiAH%2F%2Bzuy3h2dvIqmwUDzYinICmZCtz%2BHOgRJCW%2BoNXYwGQBowJsoHiajeBMt8dTS1Ilocv5vPlcYECmYPYyIfErZSh2vPr0aFw0QIyO%2F0y6O0RbsD2nU90wwrx2grNyfiX%2Bz%2F5j8LXa0nNHT%2FTJlWYOt3F%2FHOnIaNJaeIi%2FVr3Zvid%2F3NwzaYoPVDsDCiWLhLinlM3cLtGRBbUzHkfxuRLc3BJqUPMWsvlwBSR5KatImc4mmQVMosOJb1rMsYHAtsqfUqeEySukmF4LFVPrFQXVAxmihU7M7ez2xxTJaAxkql47AS%2FnGWncABAdMddMws1vcR6KyshTgrKubfT8h%2BmFaCOmPacnd2Gkx%2BZ4%2FRGBB8AV1B8EpTetfIUWz2CzSmoOpBwIWQ0FF6bQDvTjPNfupX2EUEt4MLKebuPkfcD3dyfI%2BJcBOF4CDkmKARrcYTQJ2J8hdCyzcdz40xjI%2B5pZscDR8Cw8lZWhp8rHoQe2kqL6WBdaUor6CdyJUlK%2FxUENIZDtULc80UtPVpOZ4FvUmtGlcHw2ixPXeMtc12rATlhRGrzNP%2F6Ir1uL3nx4XasMQBnMKz5rRpFtaqDaBTmktMJdFsghefLqbiNRBwqsq9I4jUxlQYsZn4kmFxuBjXCSrrXHYgAxNBLvo22beUp6%2BrqB%2BSHROo3KAck2FKDcuhsoQxfchyNtX%2FJUT12MJ7re93vvKACa8Kg%2BeCjRdrW1ecFUqwGmFdJ9mfM%2F6TgJBOVdEhN2WgW%2F5zcF%2FTDK0YL0pXymnojBYNEsIOJhShaPt%2BaNNGp4N2oDkBPTh72Hs1qNw24XPb6am%2Fi3ov8hafrJAmUOImrREJQvv7OPsH46fU2WCY5PAFWpWkvjzZIR9onqlIImC7tjJTWBqEzZnGA%2FpzcSyOudMJ6Hkq0GOrEBdLF2JCh44TnQLOQVNCGgEs%2BfLeKnketHPRW6oVrJu4eYUDuqwOHLJHsaYJ7cwVjmCJynVE7R%2BDVRMOcvmrd%2B0qZSRnjoR5bklgAgIKSp9LG8bQtrb23tsKcS4l9Mzo5PIfpJxNM8MooI%2F9AyH%2FXntVwyitd3hRidB2dmhAY%2FDWmJY1J1haR%2FWP4P%2FYkLip0pmJ2tqBHmzslCmUsR24aU3DnwsjsD6tWXHh%2FKWaak8ssy&X-Amz-Signature=0d01e41d502e07a0ee7540bd123475597efc7fae4652238e6dfc476704fa7f50&X-Amz-SignedHeaders=host","selfieImageUrl":"https:\/\/prod-audit-portal-sgp.s3.ap-southeast-1.amazonaws.com\/gkyc-ap-southeast-1\/checkLiveness\/2024-01-15\/hgqa2f\/1705281219097-ffe77ccd-5e2f-4bb8-a4b0-25a97ced90fd\/image.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAZRKK5ZMRSHZDW3EC%2F20240115%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20240115T060418Z&X-Amz-Expires=900&X-Amz-Security-Token=IQoJb3JpZ2luX2VjENn%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiEApZmmdGF0%2Bysdj0FCRpVySDR%2BOvsYA2yj8qI%2Bx%2FbQ6eQCIEnJslUuyBV5rtpuTlmlg%2BUoGgjwCv045ldEKYHC8j9QKscFCIL%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjU1Njc2NTI1MzQ3IgxhyiAH%2F%2Bzuy3h2dvIqmwUDzYinICmZCtz%2BHOgRJCW%2BoNXYwGQBowJsoHiajeBMt8dTS1Ilocv5vPlcYECmYPYyIfErZSh2vPr0aFw0QIyO%2F0y6O0RbsD2nU90wwrx2grNyfiX%2Bz%2F5j8LXa0nNHT%2FTJlWYOt3F%2FHOnIaNJaeIi%2FVr3Zvid%2F3NwzaYoPVDsDCiWLhLinlM3cLtGRBbUzHkfxuRLc3BJqUPMWsvlwBSR5KatImc4mmQVMosOJb1rMsYHAtsqfUqeEySukmF4LFVPrFQXVAxmihU7M7ez2xxTJaAxkql47AS%2FnGWncABAdMddMws1vcR6KyshTgrKubfT8h%2BmFaCOmPacnd2Gkx%2BZ4%2FRGBB8AV1B8EpTetfIUWz2CzSmoOpBwIWQ0FF6bQDvTjPNfupX2EUEt4MLKebuPkfcD3dyfI%2BJcBOF4CDkmKARrcYTQJ2J8hdCyzcdz40xjI%2B5pZscDR8Cw8lZWhp8rHoQe2kqL6WBdaUor6CdyJUlK%2FxUENIZDtULc80UtPVpOZ4FvUmtGlcHw2ixPXeMtc12rATlhRGrzNP%2F6Ir1uL3nx4XasMQBnMKz5rRpFtaqDaBTmktMJdFsghefLqbiNRBwqsq9I4jUxlQYsZn4kmFxuBjXCSrrXHYgAxNBLvo22beUp6%2BrqB%2BSHROo3KAck2FKDcuhsoQxfchyNtX%2FJUT12MJ7re93vvKACa8Kg%2BeCjRdrW1ecFUqwGmFdJ9mfM%2F6TgJBOVdEhN2WgW%2F5zcF%2FTDK0YL0pXymnojBYNEsIOJhShaPt%2BaNNGp4N2oDkBPTh72Hs1qNw24XPb6am%2Fi3ov8hafrJAmUOImrREJQvv7OPsH46fU2WCY5PAFWpWkvjzZIR9onqlIImC7tjJTWBqEzZnGA%2FpzcSyOudMJ6Hkq0GOrEBdLF2JCh44TnQLOQVNCGgEs%2BfLeKnketHPRW6oVrJu4eYUDuqwOHLJHsaYJ7cwVjmCJynVE7R%2BDVRMOcvmrd%2B0qZSRnjoR5bklgAgIKSp9LG8bQtrb23tsKcS4l9Mzo5PIfpJxNM8MooI%2F9AyH%2FXntVwyitd3hRidB2dmhAY%2FDWmJY1J1haR%2FWP4P%2FYkLip0pmJ2tqBHmzslCmUsR24aU3DnwsjsD6tWXHh%2FKWaak8ssy&X-Amz-Signature=a0cc21d66bd0cb200380606a9c6a1820cc08855701ccf3bc07cc7a6903fad755&X-Amz-SignedHeaders=host","idChecks":{"blur":"no","glare":"no","black and white":"no","captured from screen":"no","partial id":"no"},"selfieChecks":{"blur":"no","eyes closed":"no","mask present":"no","multiple faces":"no"},"by":"lester@hurtado.ph"},"dataRetrievedAt":"2024-01-15T14:04:19+08:00","filepath":"watermarked\/9b1827c4-f374-443d-97e7-58a28043c6ac\/9b182ba6-842f-4531-9d38-920e5a904358.pdf","documentUrl":"https:\/\/kwyc-check.net\/document\/proforma\/9b182ba6-842f-4531-9d38-920e5a904358"}}';
            $json = __($json_template, [
                'code' => $code,
                'email' => $order->seller->email,
                'fullName' => $fullName,
                'address' => $address,
                'dateOfBirth' => $dateOfBirth,
                'idType' => $idType,
                'idNumber' => $idNumber,
            ]);

            $array = json_decode($json, true);
            $voucher = ProcessBuyerAction::run($array);
            $code_url = $this->faker->url();
            $code_img_url = $this->faker->url();
            $date = Carbon::now();
            $date->addDays(config('rli-payment.expires_in'));
            $expiration_date = $date->format('YmdHis');
            $voucher = AcquirePaymentDetailsAction::run([
                'reference_code' => $voucher->code,
                'code_url' => $code_url,
                'code_img_url' => $code_img_url,
                'expiration_date' => $expiration_date,
            ]);
            InvoiceBuyerAction::run($voucher);
        })
    ]
]);

test('acknowledge payment action runs', function (Voucher $voucher) {
    Notification::fake();
    $order = $voucher->getOrder();    
    $order->seller->email="clandrade@joy-nostalg.com";
    $order->seller->save();
    expect($order->state)->toBeInstanceOf(InvoicedPendingPayment::class);
    $payment_id = $this->faker->word();
   
    AcknowledgePaymentAction::execute(['reference_code' => $voucher->code, 'payment_id' => $payment_id]);   
    // Notification::assertSentTo($order->seller, PaymentConfirmedNotification::class);

   Notification::assertSentTo($order->seller, PaymentConfirmedNotification::class, function (PaymentConfirmedNotification $notification) use ($voucher, $payment_id) {
       return $notification->voucher->is($voucher) && $notification->payment_id == $payment_id;
   });
    expect($order->fresh()->state)->toBeInstanceOf(PaidPendingFulfillment::class);
    Event::assertDispatched(PaymentAcknowledged::class);
})->with('voucher');

test('acknowledge payment action has end points', function (Voucher $voucher) {
    $order = $voucher->getOrder();
    $code_url = $order->code_url;
    $code_img_url = $order->code_img_url;
    $expiration_date = $order->expiration_date;
    $payment_id = $this->faker->word();
    $response = $this->postJson(route('acknowledge-payment'), [
        'reference_code' => $voucher->code,
        'payment_id' => $payment_id
    ]);
    $response->assertStatus(200);
    expect($order->fresh()->payment_id)->toBe($payment_id);
    $response->assertJsonFragment(['paid-using' => compact( 'payment_id')]);
})->with('voucher');
