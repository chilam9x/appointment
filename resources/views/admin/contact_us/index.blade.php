@extends('layouts.app')

@section('content')
<h3 class="page-title">Contact us</h3>


<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_list')
    </div>

    <div class="panel-body table-responsive">
        <table
            class="table table-bordered table-striped {{ count($contact) > 0 ? 'datatable' : '' }} @can('client_delete') dt-select @endcan">
            <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    <th>@lang('quickadmin.clients.fields.first-name')</th>
                    <th>@lang('quickadmin.clients.fields.last-name')</th>
                    <th>@lang('quickadmin.clients.fields.phone')</th>
                    <th>@lang('quickadmin.clients.fields.email')</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @if (count($contact) > 0)
                @foreach ($contact as $c)
                <tr>
                    <td></td>
                    <td>{{ $c->first_name }}</td>
                    <td>{{ $c->last_name }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->email }}</td>
                    <td> {{ $c->comment }} </td>
                    <td> {{ $c->created_at }} </td>
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