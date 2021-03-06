@extends('layouts.customer')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<!-- Appointment-->
<div id="appointment">
    <h2 class="text-center">REQUEST AN APPOINTMENT</h2>
    <div class="text-center container">
    <span class="bg-success col-sm-12" id="noti-success" style="display:none"> You have successfully scheduled an appointment</span>
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
                            <form class="form-inline" action="{{url('search-appointment')}}" method="POST">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <label for="pwd">Category:</label>
                                    <select class="form-control" name="category_id" id='sltCategory'>
                                        <option value="0">Please choose</option>
                                        @foreach($category as $c)
                                        <option value="{{$c->id}}" {{$c->id==$category_id ? "selected": ''}}>
                                            {{$c->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Advisor:</label>
                                    <select class="form-control" name="advisor_id" id="sltAdvisor">
                                        <option value="0">Please choose</option>
                                        @if($advisor != '')
                                        @foreach($advisor as $a)
                                        <option value="{{$a->id}}" {{$a->id==$advisor_id ? "selected": ''}}>
                                            {{$a->first_name}} {{$a->last_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning">Search</button>
                            </form>
                        </div>
                        <div class="col-sm-12">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal event click-->
    <div id="eventContent" title="Event Details" style="display:none;">
        <strong> Start: </strong> <span id="startTime"></span> ,
        <strong> End: </strong><span id="endTime"></span><br>
        <form class="form-horizontal" action="add-student" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="id" name="id" value="">
            <div class="col-sm-6">
                <div class="form-group">
                    <h5>Category:</h5>
                    <input class="form-control" id="category_name" type="text" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <h5>Advisor:</h5>
                    <input class="form-control" id="advisor_name" type="text" disabled>
                </div>
            </div>
            <div class="col-sm-6" id="first_name">
                <div class="form-group">
                    <h5>* First Name: </h5>
                    <input class="form-control" name="first_name" type="text" required>
                </div>
            </div>
            <div class="col-sm-6" id="last_name">
                <div class="form-group">
                    <h5>* Last Name: </h5>
                    <input class="form-control" name="last_name" type="text" required>
                </div>
            </div>
            <div class="col-sm-6" id="asu_id">
                <div class="form-group">
                    <h5>* ASU ID #: <span id="limit_asu_id" class="text-danger"></span> </h5>
                    <input class="form-control" id="ip_asu_id" name="asu_id" type="number" required>
                </div>
            </div>
            <div class="col-sm-6" id="email">
                <div class="form-group">
                    <h5>* Email Address: </h5>
                    <input class="form-control" name="email" type="email" required>
                </div>
            </div>
            <div class="col-sm-6" id="phone">
                <div class="form-group">
                    <h5>* Phone Number (optional): </h5>
                    <input class="form-control" name="phone" type="tel" required>
                </div>
            </div>
            <div class="col-sm-6" id="reason">
                <div class="form-group">
                    <h5>* Reason: </h5>
                    <textarea class="form-control" name="reason" type="text" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <label class="checkbox-inline" id="phone_call"><input type="checkbox" value="1" name="phone_call">Phone
                    call
                    appointment</label>
                <button type="submit" class="btn btn-danger" id="btnSave">Save</button>
            </div>
        </form>
    </div>
    @if( $success == 1)
    <script>
        $(function() {
            $('#noti-success').css("display", "block");
        });
    </script>
    @endif
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
                    @if($appointments)
                        @foreach($appointments as $a) {
                            id: "{{$a->id}}",
                            category_name: "{{$a->name}}",
                            advisor_name: "{{$a->first_name}}" + " " + "{{$a->last_name}}",
                            status: "{{$a->status}}",
                            title: "Make an appointment",
                            start: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->start_time}}',
                            end: moment('{{$a->date}}').format('YYYY-MM-DD') + ' {{$a->finish_time }}',
                            color: "#fec627",
                        },
                        @endforeach
                    @endif    
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
            $('#btnSave').click(function() {
                var asu_id = $('#ip_asu_id').val();
                if (asu_id.length == 10) {
                    $('#limit_asu_id').html('');
                    return true;
                } else {
                    $('#limit_asu_id').html('Please enter 10 characters');
                    return false;
                }
            });
            $('#sltCategory').change(function() {
                var Id = $('#sltCategory').val();
                $.ajax({
                    type: "GET",
                    url: 'ajax/search-category-advisor',
                    data: {
                        id: Id
                    },
                    success: function(data) {
                        $("#sltAdvisor").empty();
                        data.forEach(function(item) {
                            $("#sltAdvisor").append("<option value = '" + item.id +
                                "'>" + item.first_name + " " + item.last_name +
                                "</option>");
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