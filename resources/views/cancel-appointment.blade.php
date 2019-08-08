@extends('layouts.customer')

@section('content')

<!--cancel appointment-->
<div id="cancel_appointment">
    <h2 class="text-center">CANCEL APPOINTMENT</h2>
    @if (Session::has('fail'))
    <span class="bg-danger"> {{ Session::get('fail') }}</span>
    @endif
    @if (Session::has('success'))
    <span class="bg-success"> {{ Session::get('success') }}</span>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Student infomation</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 form-inline text-center">
                                <form class="form-horizontal" action="check-student" method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label for="focusedInput">* ASU ID #: </label>
                                        <input class="form-control" name="asu_id" type="text" placeholder="Enter ASU ID">
                                        <button type="submit" class="btn  btn-warning">Check</button>
                                    </div>
                                </form>
                            </div>
                            @if($student!=null)
                            <div class="col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Category</th>
                                            <th>Advisor</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Phone call</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($student as $s)
                                        <tr>
                                            <td>{{$s->first_name}}</td>
                                            <td>{{$s->last_name}}</td>
                                            <td>{{$s->email}}</td>
                                            <td>{{$s->phone}}</td>
                                            <td>{{$s->category_name}}</td>
                                            <td>{{$s->advisor_first_name}} {{$s->advisor_last_name}}</td>
                                            <td>{{$s->date}}</td>
                                            <td>{{$s->time}}</td>
                                            <td>{{($s->phone_call==1) ? 'yes' :''}}</td>
                                            <td>{{date("d-m-Y", strtotime($s->created_at))}}</td>
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
@endsection