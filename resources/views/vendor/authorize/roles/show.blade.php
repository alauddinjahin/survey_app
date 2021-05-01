@extends('backend.layouts.master')
@section('title', 'Show Role')
@push('css')
{{-- <link href="/vendor/authorize/css/app.css" rel="stylesheet"> --}}
@endpush

@section('content')
    <div class="container-fluid my-5">
        <div class="row">
            @include('vendor.authorize.layouts.menu')

            <div class="col-md-8">
                <div class="px-3 py-3 panel panel-default card">
                    <div class="panel-heading">Role {{ $role->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles/' . $role->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Role"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['roles', $role->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Role',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $role->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Name </th>
                                        <td> {{ $role->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Alias </th>
                                        <td> {{ $role->alias }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection