@extends('layouts.customer')

@section('content')
<!-- contact us-->
<div id="contact_us">
    <h2 class="text-center">CONTACT US</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <p>Contact us and we'll get back to you within 24 hours.</p>
                <p><span class="glyphicon glyphicon-map-marker"></span> Chicago, US</p>
                <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
                <p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p>
            </div>
            <div class="col-sm-7 ">
                @if (Session::has('fail'))
                <span class="bg-danger"> {{ Session::get('fail') }}</span>
                @endif
                @if (Session::has('success'))
                <span class="bg-success"> {{ Session::get('success') }}</span>
                @endif
                <form method="POST" action="{{ url('contact-us') }}" id='formContactUs'>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="first_name" name="first_name" placeholder="First Name"
                                type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="last_name" name="last_name" placeholder="Last Name"
                                type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="email" name="email" placeholder="Email" type="email"
                                required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="phone" name="phone" placeholder="Phone" type="tel" required>
                        </div>
                    </div>
                    <textarea class="form-control" id="comments" name="comment" placeholder="Comment"
                        rows="5"></textarea><br>
                    <div class="row">
                        <div class="col-sm-12 form-group form-contact">
                            <button class="btn btn-lg pull-right" type="submit">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection