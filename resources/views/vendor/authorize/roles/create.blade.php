@extends('backend.layouts.master')
@section('title', 'Create Role')
@push('css')
{{-- <link href="/vendor/authorize/css/app.css" rel="stylesheet"> --}}
@endpush

@section('content')
    <div class="container mx-auto my-5">
        <div class="panel panel-default card">
            <div class="panel-heading text-center">Create New Role</div>
            <div class="panel-body">
                <a class="btn btn-sm btn-info float-right mb-2 mr-2" href="{{ url('authorize') }}"> Back</a>

    
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
    
                {!! Form::open(['url' => '/' . Config("authorization.route-prefix") . '/roles', 'class' => 'form-horizontal', 'files' => true]) !!}
    
                @include ('vendor.authorize.roles.form')
    
                {!! Form::close() !!}
    
            </div>
        </div>
    </div>
@endsection