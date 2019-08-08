@extends('layouts.app')

@section('content')
<h3 class="page-title">Category</h3>
@if (Session::has('fail'))
<span class="bg-danger"> {{ Session::get('fail') }}</span>
@endif
@if (Session::has('success'))
<span class="bg-success"> {{ Session::get('success') }}</span>
@endif
<p>
    <button type="button" class="btn btn-success =" data-toggle="modal" data-target="#create">@lang('quickadmin.qa_add_new')</button>
</p>
<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_list')
    </div>

    <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped {{ count($category) > 0 ? 'datatable' : '' }} @can('client_delete') dt-select @endcan">
            <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if (count($category) > 0)
                @foreach ($category as $c)
                <tr>
                    <td></td>
                    <td>{{ $c->name }}</td>
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
<!-- Modal -->
<div class="modal fade" id="create" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new Category</h4>
            </div>
            <form class="form-horizontal" action="create-category" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-sm-3">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name">
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

@section('javascript')

@endsection