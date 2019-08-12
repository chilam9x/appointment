@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('quickadmin.appointments.title')</h3>


<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<div class="container">
<div id='calendar'></div>
</div>

<br />

<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_list')
    </div>

    <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }} @can('appointment_delete') dt-select @endcan">
            <thead>
                <tr>
                    @can('appointment_delete')
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    @endcan
                    <th>ASU ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Reason</th>
                    <th>Category</th>
                    <th>Advisor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Phone call</th>
                    <th>Create date</th>
                    <th  class="text-danger">Reason cancel</th>
                    <th  class="text-danger">Delete date</th>
                </tr>
            </thead>

            <tbody>
                @if (count($appointments) > 0)
                @foreach ($appointments as $appointment)
                <tr>
                    <td></td>
                    <td>{{$appointment->asu_id}}</td>
                    <td>{{$appointment->first_name}} {{$appointment->last_name}}</td>
                    <td>{{$appointment->email}}</td>
                    <td>{{$appointment->phone}}</td>
                    <td>{{$appointment->reason}}</td>
                    <td>{{$appointment->category_name}}</td>
                    <td>{{$appointment->advisor_first_name}} {{$appointment->advisor_last_name}}</td>
                    <td>{{$appointment->date}}</td>
                    <td> Form {{$appointment->start_time}} to {{$appointment->finish_time}}</td>
                    <td>{{($appointment->phone_call==1) ? 'yes' :''}}</td>
                    <td>{{$appointment->ap_created_at}}</td>
                    <td>{{$appointment->reason_cancel}}</td>
                    <td >{{$appointment->ap_deleted_at}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop

@section('javascript')


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
                    title: {{$appointment -> phone_call}} == 1 ? "Phone call appointment" : "Make an appointment",
                    start: moment('{{$appointment->date}}').format('YYYY-MM-DD') + ' {{$appointment->start_time}}',
                    end: moment('{{$appointment->date}}').format('YYYY-MM-DD') + ' {{$appointment->finish_time}}',
                },
                @endforeach
            ]
        })
    });
</script>
@endsection