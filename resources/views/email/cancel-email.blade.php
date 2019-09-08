<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cancel an appointment</title>
</head>

<body>
    <p> {{$e_message}} </p>
    <p>If you have any additional questions, use the contact details below to get in touch with us. </p>
    @component('mail::button', ['url' => $link])
    Request an appointment
    @endcomponent
    <p>Looking forward to your present</p>
</body>

</html>