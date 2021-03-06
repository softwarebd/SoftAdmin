@extends('softadmin::backend.master')

@section('page_header')
    <h1 class="page-title">
        <i class="softadmin-list-add"></i> {{ $dataType->display_name_plural }}
        <a href="{{ route('softadmin.'.$dataType->slug.'.create') }}" class="btn btn-success">
            <i class="softadmin-plus"></i> Add New
        </a>
    </h1>
@stop

@section('page_header_actions')

@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>How To Use:</strong>
            <p>You can output a menu anywhere on your site by calling <code>Menu::display('name')</code></p>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                @foreach($dataType->browseRows as $rows)
                                <th>{{ $rows->display_name }}</th>
                                @endforeach
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                    <td>
                                        @if($row->type == 'image')
                                            <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Softadmin::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                        @else
                                            {{ $data->{$row->field} }}
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                            <i class="softadmin-trash"></i> Delete
                                        </div>
                                        <a href="{{ route('softadmin.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                            <i class="softadmin-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('softadmin.'.$dataType->slug.'.builder', $data->id) }}" class="btn-sm btn-success pull-right">
                                            <i class="softadmin-list"></i> Builder
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="softadmin-trash"></i> Are you sure you want to delete this {{ $dataType->display_name_singular }}?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('softadmin.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Yes, Delete This {{ $dataType->display_name_singular }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({ "order": [] });
        });

        $('td').on('click', '.delete', function (e) {
            id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });
    </script>
@stop
