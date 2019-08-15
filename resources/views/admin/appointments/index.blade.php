@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('quickadmin.appointments.title')</h3>
@if (Session::has('fail'))
<span class="bg-danger"> {{ Session::get('fail') }}</span>
@endif
@if (Session::has('success'))
<span class="bg-success"> {{ Session::get('success') }}</span>
@endif
<p>
    <button type="button" class="btn btn-success =" data-toggle="modal" data-target="#create">@lang('quickadmin.qa_add_new')</button>
</p>

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
                    <th class="text-danger">Reason cancel</th>
                    <th class="text-danger">Delete date</th>
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
                    <td>{{$appointment->ap_deleted_at}}</td>
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
<!-- Modal create-->
<div class="modal fade" id="create" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new an appointment</h4>
            </div>
            <form  action="create-appointment" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-body">
                    <div >
                        <div class="form-group">
                            <label for="email">Category:</label>
                            <select class="form-control" name="category_id">
                                @foreach($category as $c)
                                    <option value="{{$c->id}}">{{$c->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Advisor:</label>
                            <select class="form-control" name="advisor_id">
                                @foreach($advisor as $a)
                                    <option value="{{$a->id}}">{{$a->first_name}} {{$a->last_name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="focusedInput">Date choose: </label>
                            <input class="form-control" name="date" type="text" id="datepicker" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="focusedInput">Start time: </label>
                            <select class="form-control" name="start_time">
                                    <option value="08:00">8:00 AM </option>
                                    <option value="08:30">8:30 AM </option>
                                    <option value="09:00">9:00 AM </option>
                                    <option value="09:30">9:30 AM </option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 AM</option>
                                    <option value="12:30">12:30 AM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="13:30">1:30 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="14:30">2:30 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="15:30">3:30 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="16:30">4:30 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="17:30">5:30 PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
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
            slotDuration: '00:15:00',
            slotEventOverlap: false,
            allDaySlot: false,

            // Display only business hours (8am to 5pm)
            minTime: "08:00",
            maxTime: "17:30",

            businessHours: {
                dow: [1, 2, 3, 4, 5], // Monday - Thursday
                start: '08:00', // start time (8am)
                end: '17:30', // end time (5pm)
            },

            hiddenDays: [0, 6], // Hide Sundays and Saturdays
            events: [
                @foreach($apm as $a) {
                    title:  "Make an appointment",
                    start: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->start_time}}',
                    end: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->finish_time }}',
                    color:  '{{$a->deleted_at}}' == '' ? ('{{$a->reason}}' == ''?"#fec627" :'#45B6AF'  ) :"#ccc",
                },
                @endforeach
            ]
            
        })
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