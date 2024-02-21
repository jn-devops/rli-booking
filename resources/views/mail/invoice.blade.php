<x-mail::message>
Dear {{$buyer->name}},<br>

Your transaction has been successfully received, and we are currently processing it.<br>
An email acknowledging receipt of your payment will be sent to you after your payment has been processed and verified successfully.<br>
Kindly see transaction details below.

Reference Code: <b>{{$voucher->code}}</b><br>
Name: <b>{{$buyer->name}}</b><br>
Address: <b>{{$buyer->address}}</b><br>
Contact Number: <b>{{$buyer->mobile}}</b><br>
Project Name: <b>{{$product->brand}}</b><br>
Unit Type: <b>{{$product->name}}</b><br>
Total Contract Price: <b>PHP{{number_format($product->price, 2)}}</b><br>
Processing Fee: <b>PHP{{number_format($product->processing_fee, 2)}}</b><br>
Mode of Payment: <b>QR PH</b><br>

Included in this email is a copy of your billing statement document.<br>

Thank You,<br>
Raemulan Lands, Inc.
</x-mail::message>
