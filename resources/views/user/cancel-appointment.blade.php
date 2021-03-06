@extends('layouts.customer')

@section('content')

<!--cancel appointment-->
<div id="cancel_appointment">
    <h2 class="text-center">CANCEL APPOINTMENT</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <span class="bg-success text-center" id="noti-success" style="display:none"> You have successfully cancelled an appointment </span>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Student infomation</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 form-inline text-center">
                                <form class="form-horizontal" action="{{url('check-student')}}" method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label for="focusedInput">* ASU ID #: </label>
                                        <input class="form-control" name="asu_id" value="{{$asu_id}}" type="text"  placeholder="Enter ASU ID">
                                        <button type="submit" class="btn  btn-warning">Check</button>
                                    </div>
                                </form>
                            </div>
                            @if($student!=null)
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Advisor</th>
                                            <th>Reason</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Phone call</th>
                                            <th>Create date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($student as $s)
                                        <tr>
                                            <td>{{$s->category_name}}</td>
                                            <td>{{$s->advisor_first_name}} {{$s->advisor_last_name}}</td>
                                            <td>{{$s->reason}}</td>
                                            <td>{{$s->date}}</td>
                                            <td> Form {{$s->start_time}} to {{$s->finish_time}}</td>
                                            <td>{{($s->phone_call==1) ? 'yes' :''}}</td>
                                            <td>{{date("d-m-Y", strtotime($s->ap_created_at))}}</td>
                                            @if($s->cancel_at==null)
                                            <td><a href="#" data-toggle="modal" data-target="#cancel" onclick="openCancelModal({{$s->id}},{{$s->apm_id}})">Cancel</a> </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cancel" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cancel an appointment</h4>
            </div>
            <form class="form-horizontal" action="cancel-appointment" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="student_id" id="student_id" value="">
                <input type="hidden" name="appointment_id" id="appointment_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="focusedInput">* Reason cancel: </label> <span id="error" class="text-danger"></span>
                        <textarea class="form-control" id="reason_cancel" name="reason_cancel" type="text" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal asu id not exitst-->
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 10%;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Warning!</h4>
            </div>
            <div class="modal-body">
                <p>You currently do not have an existing appointment, click yes to redirect to the request an appointment page</p>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-warning" href="{{url('appointment')}}">Create new</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if( $error_code == 5)
<script>
    $(function() {
        $('#myModal').modal('show');
    });
</script>
@endif
@if( $success == 1)
<script>
    $(function() {
        $('#noti-success').css("display", "block");
    });
</script>
@endif
<script>
    function openCancelModal(student_id, appointment_id) {
        $('#student_id').val(student_id);
        $('#appointment_id').val(appointment_id);
    }
</script>
@endsection