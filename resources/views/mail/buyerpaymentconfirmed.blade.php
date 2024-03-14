<x-mail::message>
Dear {{$buyer->name}},<br>

We're thrilled to confirm receipt of your payment for the processing fee, securing your reservation for the below property:<br>

Reference Code: <b>{{$voucher->code}}</b><br>
Name: <b>{{$buyer->name}}</b><br>
Project Name: <b>{{$product->brand}}</b><br>
Unit Type: <b>{{$product->name}}</b><br>
Amount: <b>₱{{number_format($product->processing_fee, 2)}}</b><br>
Particulars: Processing Fee

Kindly see the attached Acknowledgment Receipt for your records.<br>

We would like to remind you to submit your latest 1-month payslip within 7 days from the date of your reservation by clicking on the following link, if you haven't done it yet:<br>
<a href="https://form.jotform.com/240572548214051/?referenceCode={{$voucher->code}}">https://form.jotform.com/240572548214051/?referenceCode={{$voucher->code}}</a><br>

Furthermore, in preparation for the Reservation Agreement and Contract to Sell, we kindly request that you fill out the client form using the following link:<br>
<a href="https://form.jotform.com/240372079173456/?referenceCode={{$voucher->code}}">https://form.jotform.com/240372079173456/?referenceCode={{$voucher->code}}</a><br>

Your prompt completion of this form will help expedite the process, ensuring a smooth transition toward finalizing the property acquisition.<br>

Should you have any queries or require assistance, please feel free to contact us. We are here to assist you every step of the way.<br>

Thank you once again for choosing Raemulan Lands, Inc. We are excited to continue working with you and look forward to the successful completion of your property reservation.<br>

Best regards,<br>
Raemulan Lands, Inc.
</x-mail::message>
