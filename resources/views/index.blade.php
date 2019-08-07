@extends('layouts.customer')

@section('content')
<!-- Appointment-->
<div id="appointment">
    <h2 class="text-center">REQUEST AN APPOINTMENT</h2>
    <div class="container">
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
                                    <input class="form-control" id="first_name" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Last Name: </label>
                                    <input class="form-control" id="last_name" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* ASU ID #: </label>
                                    <input class="form-control" id="asu_id" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Email Address: </label>
                                    <input class="form-control" id="first_name" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Phone Number (optional): </label>
                                    <input class="form-control" id="last_name" type="text">
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

                                    <select class="form-control" id="sel1">
                                        @foreach($category as $c)
                                        <option value="{{$c->id}}">{{$c->name}} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Advisor: </label>
                                    <select class="form-control" id="sel2">
                                    @foreach($advisor as $a)
                                        <option value="{{$a->id}}">{{$a->first_name}} {{$a->last_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">Date choose: </label>
                                    <input class="form-control" id="asu_id" type="date">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">Time choose: </label>
                                    <input class="form-control" id="first_name" type="time">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="checkbox-inline"><input type="checkbox" value="">Phone call
                                        appointment</label>
                                </div>
                            </div>
                            <div class="col-sm-12">

                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <button class="btn btn-lg">Submit</button>
                        <button class="btn btn-lg">Reset</button>
                    </div>
                </div>
            </div>
        </div>
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
                title: "{{ $appointment->client->first_name . '' . $appointment->client->last_name }}",
                start: "{{ $appointment->start_time }}",
                @if($appointment.finish_time)
                end: "{{ $appointment->finish_time }}",
                @endif
                url: "{{ route('admin.appointments.edit ', $appointment->id) }}"
            },
            @endforeach
        ]
    })
});
</script>
@endsection