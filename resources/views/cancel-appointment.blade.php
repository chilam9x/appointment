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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Reason: </label>
                                    <input class="form-control" id="reason" type="text">
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
                                        <option>general inquiries </option>
                                        <option>sponsored students</option>
                                        <option>category 3</option>
                                        <option>category 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="focusedInput">* Advisor: </label>
                                    <select class="form-control" id="sel1">
                                        <option>name 1 </option>
                                        <option>name 2</option>
                                        <option>name 3</option>
                                        <option>name 4</option>
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
@endsection