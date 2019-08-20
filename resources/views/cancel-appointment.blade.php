@extends('layouts.customer')

@section('content')

<!--cancel appointment-->
<div id="cancel_appointment">
    <h2 class="text-center">CANCEL APPOINTMENT</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 ">
                @if (Session::has('fail'))
                <span class="bg-danger"> {{ Session::get('fail') }}</span>
                @endif
                @if (Session::has('success'))
                <span class="bg-success"> {{ Session::get('success') }}</span>
                @endif
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
                                        <input class="form-control" name="asu_id" type="text"
                                            placeholder="Enter ASU ID">
                                        <button type="submit" class="btn  btn-warning">Check</button>
                                    </div>
                                </form>
                            </div>
                            @if($student!=null)
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($student as $s)
                                        <tr>
                                            <td>{{$s->asu_id}}</td>
                                            <td>{{$s->first_name}} {{$s->last_name}}</td>
                                            <td>{{$s->email}}</td>
                                            <td>{{$s->phone}}</td>
                                            <td>{{$s->reason}}</td>
                                            <td>{{$s->category_name}}</td>
                                            <td>{{$s->advisor_first_name}} {{$s->advisor_last_name}}</td>
                                            <td>{{$s->date}}</td>
                                            <td> Form {{$s->start_time}} to {{$s->finish_time}}</td>
                                            <td>{{($s->phone_call==1) ? 'yes' :''}}</td>
                                            <td>{{date("d-m-Y", strtotime($s->ap_created_at))}}</td>
                                            @if($s->cancel_at==null)
                                            <td><a href="#" data-toggle="modal" data-target="#cancel"
                                                    onclick="openCancelModal({{$s->id}})">Cancel</a> </td>
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
                <div class="modal-body">
                    <div class="form-group">
                        <label for="focusedInput">* Reason cancel: </label> <span id="error" class="text-danger"></span>
                        <textarea class="form-control" id="reason_cancel" name="reason_cancel" type="text" rows="5"
                            required></textarea>
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
                <p>ASU ID does not exist, do you want to create one
                    Appointment?</p>
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
<script>
function openCancelModal(student_id) {
    $('#student_id').val(student_id);
}
</script>
@endsection