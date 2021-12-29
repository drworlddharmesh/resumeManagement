
<!DOCTYPE html>
<html lang="en">

<body>
<p>Hi,</p>
@php
date_default_timezone_set('Asia/Kolkata');
        $CurrentDate = date("d/m/Y h:i:s A");
 @endphp
 <p>Date: {{ $CurrentDate }}<br>
 Name: {{$name}} <br>
 Address: {{$address}}
</p>
<p>LETTER OF DEMAND</p>
<p>We are writing in reference to the contract with our clients Search Jobs For You. We are advising you to pay the charges of the portal which you have used intentionally and failed to deliver the output which was required in the contract. Now we can proceed legally as per the sec 72 under Indian contract act 1872. Kindly clear the dues towards our clients in the below account details and resolve this matter at the earliest to avoid law suit. Now, as per the terms and conditions mentioned in the legal agreement you are supposed to pay the charges of Rs 5000+GST applicable as soon as possible to the below mentioned account.</p>
<p>This will be your final opportunity to resolve the matter without the expense of court proceedings. If you fail to clear the matter then the company may take legal actions against you. For the same, we will be serving you the legal notice to your postal address against which you have to revert legally and we do have your Aadhar card & Pan Card details with us so, we can deteriorate your CIBIL rating as well in course of non-submission of your penalty amount. You can find lots of issues with your banking procedures also then. As soon as you will pay the amount you will get NOC (No objection certificate) from our company.</p>

<p>Regards,<br>
Legal Department<br>
Legal Law firm<br>
+91 {{$phone}}
</p>
</body>
</html>