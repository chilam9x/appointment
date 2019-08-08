@extends('layouts.customer')

@section('content')
<!-- Appointment-->
<div id="appointment">
    <h2 class="text-center">REQUEST AN APPOINTMENT</h2>
    @if (Session::has('fail'))
    <span class="bg-danger"> {{ Session::get('fail') }}</span>
    @endif
    @if (Session::has('success'))
    <span class="bg-success"> {{ Session::get('success') }}</span>
    @endif
    <div class="container">
        <form class="form-horizontal" action="appointment" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5>Student infomation</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* First Name: </label>
                                        <input class="form-control" name="first_name" type="text" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* Last Name: </label>
                                        <input class="form-control" name="last_name" type="text" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* ASU ID #: </label>
                                        <input class="form-control" name="asu_id" type="text" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* Email Address: </label>
                                        <input class="form-control" name="email" type="email" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* Phone Number (optional): </label>
                                        <input class="form-control" name="phone" type="tel" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5>Appointment infomation</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* Category: </label>
                                        <select class="form-control" name="category_id">
                                            @foreach($category as $c)
                                            <option value="{{$c->id}}">{{$c->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="focusedInput">* Advisor: </label>
                                        <select class="form-control" name="advisor_id">
                                            @foreach($advisor as $a)
                                            <option value="{{$a->id}}">{{$a->first_name}} {{$a->last_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="checkbox-inline"><input type="checkbox" value="1" name="phone_call">Phone call
                                            appointment</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="focusedInput">Date choose: </label>
                                        <input class="form-control" name="date" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedInput">Time choose: </label>
                                        <input class="form-control" name="time" id='time' type="time" value='now' required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <button type="submit" class="btn btn-lg">Submit</button>
                            <button type="reset" class="btn btn-lg">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            defaultView: 'agendaWeek',
            events: [
                @foreach($appointments as $appointment) {
                    title: {{$appointment->phone_call}} == 1 ? "Phone call appointment" : "Make an appointment",
                    start: moment('{{$appointment->date}}').format('YYYY-MM-DD') + ' {{$appointment->time}}',
                },
                @endforeach
            ]
        })
    });
    $(function() {
        var d = new Date(),
            h = d.getHours(),
            m = d.getMinutes();
        if (h < 10) h = '0' + h;
        if (m < 10) m = '0' + m;
        $('input[type="time"][value="now"]').each(function() {
            $(this).attr({
                'value': h + ':' + m
            });
        });
    });
</script>
@endsection