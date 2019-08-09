<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Theme Made By www.w3schools.com -->
    <title>Appointment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link href="{{ URL::asset('public/css/style.css') }}" rel="stylesheet" />
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="col-sm-3">
                <a class="navbar-brand" href="{{url('/')}}"><img width="150" src="{{url('public/img/logo.png')}}" /></a>
            </div>
            <div class="col-sm-9">
                <h2>Internatial Student and Scholars Center</h2>
            </div>
        </div>
    </nav>

    @yield('content')
    <footer class="container-fluid text-center bg-grey">
        <a href="#myPage" title="To Top">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a>
        <p>ASU is #1 <a href="#!">in the U.S for Innovation</a></p>
    </footer>
</body>

</html>