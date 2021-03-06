@extends('backend.layouts.master')
@section('title', 'Permissions')
@push('css')
<link href="/vendor/authorize/css/tree.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container my-5">
        <div class="panel panel-default card my-5">
            <div class="panel-heading text-center my-2">Update Permission</div>
            <div class="panel-body">
                <a class="btn btn-sm btn-info float-right mb-2 mr-2" href="{{ url('authorize') }}"> Back</a>

    
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
    
                {!! Form::open(['url' => '/' . Config("authorization.route-prefix") . '/permissions', 'class' => 'form-horizontal']) !!}
                <div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}">
                    {!! Form::label('role_id', 'Role', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-12">
                        {!! Form::select('role_id', $roles, null, ['placeholder' => 'Please select ...', 'class' => 'form-control', 'required' => 'required']) !!}
                        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('controller') ? 'has-error' : ''}}">
                    {!! Form::label('controller', 'Actions', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-12">
                        <ul id="tree">
                            @foreach($actions as $namespace => $controllers)
                            <li>{{ $namespace }}
                                <ul>
                                    @foreach($controllers as $controller => $methods)
                                    <li>{{ $controller }}
                                        <ul>
                                            @foreach($methods as $method => $actions)
                                            <li>{{ $method }}
                                                <ul>
                                                    @foreach($actions as $action)
                                                        <li>
                                                            {{ Form::checkbox('actions[]', $namespace . '-' . $controller . '-' . $method . '-' . $action, null, ['class' => 'field']) }}
                                                            {{ $action }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
    
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
    
                {!! Form::close() !!}
    
            </div>
        </div>
    </div>
@endsection


@push('js')
<script> 
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
</script>
<script src="/vendor/authorize/js/app.js"></script>

<script src="/vendor/authorize/js/tree.js"></script>
<script>
    $(function () {
        $('#role_id').on('change', function () {
            var role_id = $(this).val();
            $('#tree').find('input[type=checkbox]:checked').prop('checked', '');
            if (role_id > 0) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },
                    type: "POST",
                    url: '{{ url('/' . Config("authorization.route-prefix") . '/permissions/getSelectedRoutes') }}',
                    data: {role_id: role_id},
                    cache: false,
                    success: function (res) {
                        $.each(res.selectedActions, function (key, val) {
                            var value = val.replace(/\\/g, '\\\\');
                            $('input[type="checkbox"][value="' + value + '"]').prop('checked', 'checked');
                        });
                    },
                    error: function (xhr, status, error) {
                        alert("An AJAX error occured: " + status + "\nError: " + error);
                    }
                });
            }
        });
    });
</script>
@endpush