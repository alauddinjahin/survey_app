@extends('backend.layouts.master')
@push('css')
{{-- <link href="/vendor/authorize/css/app.css" rel="stylesheet"> --}}
@endpush

@section('content')
    <div class="container my-5">
        <div class="panel panel-default card">
            <div class="panel-heading text-center">Edit Role {{ $role->id }}</div>
            <div class="panel-body">
                <a class="btn btn-sm btn-info float-right mb-2 mr-2" href="{{ url('authorize') }}"> Back</a>
    
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
    
                {!! Form::model($role, [
                    'method' => 'PATCH',
                    'url' => ['/' . Config("authorization.route-prefix") . '/roles', $role->id],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}
    
                @include ('vendor.authorize.roles.form', ['submitButtonText' => 'Update'])
    
                {!! Form::close() !!}
    
            </div>
        </div>
    </div>
@endsection