@extends('backend.layouts.master')

@push('css')
@endpush
@section('content')
<div id="app">
    <div class="container-fluid my-3">
        <div class="panel-heading">
            <h3 class="panel-title">Menu</h3>
        </div>
        <div class="row d-flex">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="list-group">
                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/users') }}"
                           class="list-group-item">Users</a>
                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/roles') }}"
                           class="list-group-item">Role</a>
                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/permissions') }}"
                           class="list-group-item">Permission</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="jumbotron">
                    <h1>Authorization</h1>
                    <p>In addition to providing authentication services out of the box, Laravel also provides a simple way to authorize user actions against a given resource. Like authentication, Laravel's approach to authorization is simple, and there are two primary ways of authorizing actions: gates and policies.</p>
                    <p>Think of gates and policies like routes and controllers. Gates provide a simple, Closure based approach to authorization while policies, like controllers, group their logic around a particular model or resource. We'll explore gates first and then examine policies.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('js')
<script src="/vendor/authorize/js/app.js"></script>
@endpush