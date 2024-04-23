<x-mail::message>
Dear {{$seller->name}},<br>

Greetings from the Raemulan Lands!<br>

We are thrilled to have you on board. Your access has been set up, and you can now start selling with ease.<br>

To log in to the <a href="{{$url}}">Seller's Portal</a> and to your <a href="https://enclaves.ph/roundcube_enclaves/">email account</a>, please use the following credentials:<br>

Username: <b>{{$seller->email}}</b><br>
Password: <b>{{$password}}</b><br>

Kindly make sure to <b>fill-out the Disbursement Enrollment Form for your commission</b> by following the steps below and <b>upload your accreditation Documents at <a href="https://jng.ph/seller-document">Seller Attachment Form</a></b>.<br>

Fill-out Disbursement Form:
1. Login to <a href="{{$url}}/user/profile">Seller's Portal.</a><br>
2. Once you're logged in, click your name at the upper corner of your screen then click Profile or click <a href="{{$url}}/user/profile">here</a>.<br>  
3. Update Account Disbursement section then click SAVE.<br>

Should you have any questions, please do not hesitate to contact us at customer.care@joy-nostalg.com<br>

Thank You,<br>
<b>Raemulan Lands, Inc.</b>
</x-mail::message>