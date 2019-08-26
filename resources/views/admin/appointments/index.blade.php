@extends('layouts.app')

@section('content')
<style>
    .ui-widget-content {
        width: 95% !important;
        top: 25% !important;
    }
</style>
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

<div class="row">
    <div class="col-sm-12">
        <div id='calendar'></div>
    </div>
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
                    <td>{{$appointment->cancel_at}}</td>
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
            <form action="create-appointment" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="email">Category:</label>
                            <select class="form-control" name="category_id" id='sltCategory'>
                                <option value="0">Please select a category</option>
                                @foreach($category as $c)
                                <option value="{{$c->id}}"> {{$c->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Advisor:</label>
                            <select class="form-control" name="advisor_id" id="sltAdvisor">
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
<!-- Modal info appointment-->
<div id="eventContent" title="Event Details" style="display:none;">
    <strong> Start: </strong> <span id="startTime"></span> ,
    <strong> End: </strong><span id="endTime"></span><br>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <h5>Advisor:</h5>
                <input class="form-control" id="advisor_name" type="text" disabled>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <h5>Category:</h5>
                <input class="form-control" id="category_name" type="text" disabled>
            </div>
        </div>
        <div class="col-sm-6" id="form_first_name">
            <div class="form-group">
                <h5>* First Name: </h5>
                <input class="form-control" id="first_name" name="first_name" type="text" required>
            </div>
        </div>
        <div class="col-sm-6" id="form_last_name">
            <div class="form-group">
                <h5>* Last Name: </h5>
                <input class="form-control" id="last_name" name="last_name" type="text" required>
            </div>
        </div>
        <div class="col-sm-6" id="form_asu_id">
            <div class="form-group">
                <h5>* ASU ID #: </h5>
                <input class="form-control" id="asu_id" name="asu_id" type="number" required>
            </div>
        </div>
        <div class="col-sm-6" id="form_email">
            <div class="form-group">
                <h5>* Email Address: </h5>
                <input class="form-control" id="email" name="email" type="email" required>
            </div>
        </div>
        <div class="col-sm-6" id="form_phone">
            <div class="form-group">
                <h5>* Phone Number (optional): </h5>
                <input class="form-control" id="phone" name="phone" type="tel" required>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="checkbox-inline" id="phone_call"><input type="checkbox" value="1" name="phone_call">Phone
                call
                appointment</label></div>
    </div>

    <div class="row">
        <div class="col-sm-6" id="form_reason">
            <div class="form-group">
                <h5>* Reason: </h5>
                <textarea class="form-control" name="reason" type="text" required rows="5"></textarea>
            </div>
        </div>
        <div class="col-sm-6" id="form_reason_cancel">
            <div class="form-group">
                <h5>* Reason cancel: </h5>
                <textarea class="form-control" id="reason_cancel" name="reason_cancel" type="text" rows="5" required></textarea>
            </div>
        </div>
    </div>


    <div class="modal-footer">
    </div>
</div>
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
                @foreach($appointments as $a) {
                    id: "{{$a->id}}",
                    category_name: "{{$a->category_name}}",
                    reason: "{{$a->reason}}",
                    reason_cancel: "{{$a->reason_cancel}}",
                    advisor_name: "{{$a->advisor_first_name}}" + " " + "{{$a->advisor_last_name}}",
                    title: "Make an appointment",
                    start: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->start_time}}',
                    end: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->finish_time }}',
                    color: '{{$a->reason_cancel}}' == '' ? ('{{$a->reason}}' == '' ? "#fec627" :
                        '#45B6AF') : "#ccc",
                },
                @endforeach
            ],
            eventRender: function(event, element) {
                element.attr('href', 'javascript:void(0);');
                element.click(function() {
                    $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                    $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                    $("#eventInfo").html(event.description);
                    $("#eventContent").dialog({
                        modal: true,
                        title: event.title,
                        width: 1000
                    });
                    $("#id").val(event.id);
                    $("#category_name").val(event.category_name);
                    $("#advisor_name").val(event.advisor_name);

                    if (event.reason != '') { //apm have student
                        $("#form_first_name").css("display", "inline");
                        $("#form_last_name").css("display", "inline");
                        $("#form_asu_id").css("display", "inline");
                        $("#form_email").css("display", "inline");
                        $("#form_phone").css("display", "inline");
                        $("#form_reason").css("display", "inline");
                        $("#form_phone_call").css("display", "inline");
                        $("#form_reason").css("display", "inline");
                        $("#form_reason_cancel").css("display", "none");
                        if (event.reason_cancel != '') { //apm cancel
                            $("#form_reason_cancel").css("display", "inline");
                            $("#reason_cancel").val(event.reason_cancel);
                        }
                    } else { //apm new
                        $("#form_first_name").css("display", "none");
                        $("#form_last_name").css("display", "none");
                        $("#form_asu_id").css("display", "none");
                        $("#form_email").css("display", "none");
                        $("#form_phone").css("display", "none");
                        $("#form_reason").css("display", "none");
                        $("#form_phone_call").css("display", " none");
                        $("#phone_call").css("display", "none");
                        $("#form_reason_cancel").css("display", "none");
                    }

                });
            }

        })
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
        $('#sltCategory').change(function() {
            var Id = $('#sltCategory').val();
            $.ajax({
                type: "GET",
                url: '../category-advisor/' + Id,
                success: function(data) {
                    $("#sltAdvisor").empty();
                    data.forEach(function(item) {
                        $("#sltAdvisor").append("<option value = '" + item.id + "'>" + item.first_name + " " + item.last_name + "</option>");
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('jqXHR:');
                    console.log(jqXHR);
                }
            })
        });
    });
</script>
@endsection