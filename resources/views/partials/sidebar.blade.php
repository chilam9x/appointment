@inject('request', 'Illuminate\Http\Request')
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu"
            data-keep-expanded="false"
            data-auto-scroll="true"
            data-slide-speed="200">
            
            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>
	
            @can('appointment_access')
            <li class="{{ $request->segment(2) == 'appointments' ? 'active' : '' }}">
                <a href="{{ route('admin.appointments.index') }}">
                    <i class="fa fa-calendar"></i>
                    <span class="title">@lang('quickadmin.appointments.title')</span>
                </a>
            </li>
            @endcan
            @can('appointment_access')
            <li class="{{ $request->segment(2) == 'contact-us' ? 'active' : '' }}">
                <a href="{{url('admin/contact-us')}}">
                <i class="fa fa-comments"></i>
                    <span class="title">Contact Us</span>
                </a>
            </li>
            @endcan
            @can('appointment_access')
            <li class="{{ $request->segment(2) == 'advisor' ? 'active' : '' }}">
                <a href="{{url('admin/advisor')}}">
                <i class="fa fa-user"></i>
                    <span class="title">Advisor</span>
                </a>
            </li>
            @endcan
            @can('appointment_access')
            <li class="{{ $request->segment(2) == 'category' ? 'active' : '' }}">
                <a href="{{url('admin/category')}}">
                <i class="fa fa-user"></i>
                    <span class="title">Category</span>
                </a>
            </li>
            @endcan

            @can('user_management_access')
                <li class="">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="title">@lang('quickadmin.user-management.title')</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @can('role_access')
                            <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.roles.index') }}">
                                    <i class="fa fa-briefcase"></i>
                                    <span class="title">
                                @lang('quickadmin.roles.title')
                            </span>
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.users.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span class="title">
                                @lang('quickadmin.users.title')
                            </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('auth.change_password') }}">
                    <i class="fa fa-key"></i>
                    <span class="title">Change password</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </div>
</div>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}
