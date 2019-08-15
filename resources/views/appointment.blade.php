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
        <div class="row">
            <div class="col-sm-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Appointment infomation</h5>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="eventContent" title="Event Details" style="display:none;">
        <strong> Start: </strong> <span id="startTime"></span> ,
        <strong> End: </strong><span id="endTime"></span><br>
        <form class="form-horizontal" action="appointment" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* First Name: </label>
                    <input class="form-control" name="first_name" type="text" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* Last Name: </label>
                    <input class="form-control" name="last_name" type="text" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* ASU ID #: </label>
                    <input class="form-control" name="asu_id" type="text" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* Reason: </label>
                    <input class="form-control" name="reason" type="text" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* Email Address: </label>
                    <input class="form-control" name="email" type="email" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="focusedInput">* Phone Number (optional): </label>
                    <input class="form-control" name="phone" type="tel" required>
                </div>

            </div>
            <div class="form-group"><label class="checkbox-inline"><input type="checkbox" value="1" name="phone_call">Phone call
                    appointment</label></div>
            <div class="modal-footer">

                <button class="btn btn-danger">Save</button>
            </div>
        </form>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                defaultView: 'agendaWeek',
                selectHelper: true,
                slotDuration: '00:15:00',
                slotEventOverlap: false,
                allDaySlot: false,

                // Display only business hours (8am to 5pm)
                minTime: "08:00",
                maxTime: "17:30",
                hiddenDays: [0, 6], // Hide Sundays and Saturdays

                events: [
                    @foreach($appointments as $a) {
                        title: "Make an appointment",
                        start: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->start_time}}',
                        end: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->finish_time }}',
                        color: '{{$a->deleted_at}}' == '' ? ('{{$a->reason}}' == '' ? "#fec627" : '#45B6AF') : "#ccc",
                    },
                    @endforeach
                ],
                eventRender: function(event, element) {
                    element.attr('href', 'javascript:void(0);');
                    element.click(function() {
                        $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                        $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                        $("#eventInfo").html(event.description);
                        $("#eventLink").attr('href', event.url);
                        $("#eventContent").dialog({
                            modal: true,
                            title: event.title,
                            width: 1000
                        });
                    });
                }
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
            $("#datepicker").datepicker({
                beforeShowDay: function(d) {
                    var day = d.getDay();
                    return [(day != 0 && day != 6)];
                }
            });
        });
    </script>
    @endsection