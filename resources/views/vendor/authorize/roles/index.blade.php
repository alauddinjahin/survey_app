@extends('backend.layouts.master')
@push('css')
{{-- <link href="/vendor/authorize/css/app.css" rel="stylesheet"> --}}
@endpush

@section('content')
    <h3 class="text-left ml-3">Menu</h3>
    <div class="container-fluid my-2 d-flex">
        @include('vendor.authorize.layouts.menu')

        <div class="col-md-8">
            <div class="panel panel-default card px-2 py-2">
                <div class="panel-body">
        
                    <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles/create') }}" class="btn btn-primary btn-xs" title="Add New Role">
                        <i class="fa fa-plus" aria-hidden="true"></i></a>
                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="rolesTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th> Name</th>
                                <th> Alias</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->alias }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles/' . $item->id) }}" class="btn btn-success btn-xs"
                                           title="View Role"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"
                                           title="Edit Role"><i class="fa fa-edit" aria-hidden="true"></i></a>
        
                                        @if($item->id > 2)
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['/' . Config("authorization.route-prefix") . '/roles', $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<span class="fa fa-trash" aria-hidden="true" title="Delete Role" />', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete Role',
                                                'onclick'=>'return confirm("Confirm delete?")'
                                        )) !!}
                                        {!! Form::close() !!}
                                        @endif
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
@endsection

@push('js')
    <script>
        $('#rolesTable').DataTable();
    </script>
@endpush