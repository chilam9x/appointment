@extends('layouts.app')

@section('content')
<h3 class="page-title">Student</h3>


<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_list')
    </div>

    <div class="panel-body table-responsive">
        <table
            class="table table-bordered table-striped {{ count($student) > 0 ? 'datatable' : '' }} @can('client_delete') dt-select @endcan">
            <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    <th>ASU ID</th>
                    <th>@lang('quickadmin.clients.fields.first-name')</th>
                    <th>@lang('quickadmin.clients.fields.last-name')</th>
                    <th>@lang('quickadmin.clients.fields.phone')</th>
                    <th>@lang('quickadmin.clients.fields.email')</th>
                    <th>Create date</th>
                </tr>
            </thead>

            <tbody>
                @if (count($student) > 0)
                @foreach ($student as $s)
                <tr>
                    <td></td>
                    <td>{{ $s->asu_id }}</td>
                    <td>{{ $s->first_name }}</td>
                    <td>{{ $s->last_name }}</td>
                    <td>{{ $s->phone }}</td>
                    <td>{{ $s->email }}</td>
                    <td> {{ $s->created_at }} </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop

@section('javascript')

@endsection
