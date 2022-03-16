@component('mail::message')
# Dear {{$details['name']}},
<p>
Thank you for your registration. 
Your registered email address is  {{$details['email']}} and phone number  {{$details['phone']}}.
</p>




@endcomponent
