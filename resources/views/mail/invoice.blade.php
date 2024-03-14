<x-mail::message>
Dear {{$buyer->name}},<br>

We are delighted to acknowledge your reservation request with the following details:<br>

Reference Code: <b>{{$voucher->code}}</b><br>
Name: <b>{{$buyer->name}}</b><br>
Address: <b>{{$buyer->address}}</b><br>
Contact Number: <b>{{$buyer->mobile}}</b><br>
Project Name: <b>{{$product->brand}}</b><br>
Unit Type: <b>{{$product->name}}</b><br>
Total Contract Price: <b>₱{{number_format($product->price, 2)}}</b><br>
Processing Fee: <b>₱{{number_format($product->processing_fee, 2)}}</b><br>
Mode of Payment: <b>QR PH</b><br>

Your interest in securing this unit is greatly appreciated, and we are thrilled to assist you throughout this process.<br>

To complete the reservation and secure the selected unit, please follow the instructions below:<br>

<b>1. Payment of Processing Fee:</b><br>
Please <b>scan the QR code</b> attached below to proceed with the payment of the processing fee. This fee is essential to finalize your reservation and ensure that the property is secured for you.</p>
<img src="{{$order->code_img_url}}">

<b>2. Submission of Latest 1-Month Payslip:</b><br>
Additionally, as part of the reservation process, we kindly request that you submit your latest 1-month payslip by clicking the <a href="https://form.jotform.com/240572548214051/?referenceCode={{$voucher->code}}">Buyer Attachment Form for Customer Qualification</a>.<br>

Included in this email is a copy of your billing statement document.<br>

<b>Kindly make the payment and submit the required document within 7 days</b> to avoid cancellation of your reservation request.<br>

Once both the processing fee payment and submission of the payslip are completed, your reservation will be considered finalized, and the unit will be secured for you.<br>

Should you have any questions or require further assistance, please do not hesitate to contact us. We are here to support you throughout this process and ensure a seamless experience.<br>

Thank you for choosing Raemulan Lands, Inc. We look forward to welcoming you to your new property soon!<br>

Best regards,<br>
<b>Raemulan Lands, Inc.</b>
</x-mail::message>