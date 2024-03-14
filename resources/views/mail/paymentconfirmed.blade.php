<x-mail::message>
Dear {{$seller->name}},<br>

This e-mail is to notify you that one of your prospect buyer has successfully paid the full amount of the processing fee.<br>

As part of our procedures, we will process the commission once all required documents are given. In the meantime, we kindly request your assistance in following up on the necessary documents required to tag the reservation as official sale.
Kindly see the buyer details below<br>

<b>Buyer Details:</b><br>
Reference Code: <b>{{$voucher->code}}</b><br>
Buyer Name: <b>{{$buyer->name}}</b><br>
Project Name: <b>{{$product->brand}}</b><br>
Unit Type: <b>{{$product->name}}</b><br>
Amount: <b>₱{{number_format($product->processing_fee, 2)}}</b><br>
Particulars: Processing Fee

Should you have any questions or require further clarification, please don't hesitate to reach out to us.<br>
We greatly appreciate your cooperation and look forward to facilitating a seamless transaction.<br>

Thank You,<br>
Raemulan Lands, Inc.
</x-mail::message>
