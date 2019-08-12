@extends('layouts.customer')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<!-- Appointment-->
<div id="appointment">
    <h2 class="text-center">REQUEST AN APPOINTMENT</h2>
    <div class="text-center">
        @if (Session::has('fail'))
        <span class="bg-danger text-center"> {{ Session::get('fail') }}</span>
        @endif
        @if (Session::has('success'))
        <span class="bg-success text-center"> {{ Session::get('success') }}</span>
        @endif
    </div>
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
                                        <label for="focusedInput">* Reason: </label>
                                        <input class="form-control" name="reason" type="text" required>
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
                                        <input class="form-control" name="date" type="text" id="datepicker" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedInput">Start time: </label>
                                        <input class="form-control" name="start_time" min="08:00" max="17:00" type="time" value='now' required>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedInput">Finish time: </label>
                                        <input class="form-control" name="finish_time" min="08:00" max="17:00" type="time" value='now' required>
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline"><input type="checkbox" value="1" name="phone_call">Phone call
                                            appointment</label>
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
            editable: true,
            eventOverlap: false,
            selectable: true,
            selectHelper: true,
            slotDuration : '00:15:00',
            slotEventOverlap: false,
            allDaySlot: false,

            // Display only business hours (8am to 5pm)
            minTime: "08:00",
            maxTime: "17:30",

            businessHours: {
                dow: [ 1, 2, 3, 4, 5], // Monday - Thursday
                start: '08:00', // start time (8am)
                end: '17:30', // end time (5pm)
            },

             hiddenDays: [ 0, 6 ],  // Hide Sundays and Saturdays

            events: [
                @foreach($appointments as $appointment) {
                    title: {{$appointment->phone_call}} == 1 ? "Phone call appointment" : "Make an appointment",
                    start: moment('{{$appointment->date}}').format('YYYY-MM-DD') + ' {{$appointment->start_time}}',
                    end: moment('{{$appointment->date}}').format('YYYY-MM-DD') + ' {{$appointment->finish_time}}',
                },
                @endforeach
            ]
        });
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
<script>
    $(function() {
        $( "#datepicker" ).datepicker(
        {
            beforeShowDay: function(d) {
                var day = d.getDay();
                return [(day != 0 && day != 6)];
            }
        });
    });
</script>
@endsection