<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request an appointment</title>
</head>

<body>
    <p> {{$e_message}} </p>
    <p>If you have any additional questions, use the contact details below to get in touch with us. </p>
    <p>To cancel or reschedule your appointment before the scheduled time, please click: cancellation page URL</p>
    @component('mail::button', ['url' => $link])
    Cancel an appointment
    @endcomponent
    <p>Looking forward to your present</p>
</body>

</html>