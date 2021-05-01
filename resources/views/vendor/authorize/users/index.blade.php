@extends('backend.layouts.master')
@section('title', 'Users')
@push('css')
<link href="{{ asset('ui/backend/plugins/data-table/data-table-custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('ui/backend/src/js/pages/vendors/vendor.css') }}">

@endpush
@section('content')
    <h3 class="text-left ml-3">Menu</h3>
    <div class="container-fluid my-2 d-flex">
        @include('vendor.authorize.layouts.menu')
        <div class="col-md-8">
            <div class="panel panel-default card">
                <div class="panel-body">
                    <div class="head my-2 mx-2">
                        <button class="btn btn-info btn-sm" id="create-user"><i class="fa fa-plus mx-1"></i>Create</button>
                    </div>
                    <div class="table-responsive px-2 py-3">
                        <table class="table table-bordered table-striped" id="usersTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Login Status</th>
                                <th class="text-center">User Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role['name']??'' }}</td>
                                    <td class="text-center">{!! $item->status?? '' !!}</td>
                                    <td class="text-center">
                                        <div class="form-group custom-control custom-switch">
                                            @if(auth()->user()->id !== $item->id)
                                             <input type="checkbox" {{ boolval($item->is_active)?"checked":"" }} value="{{ $item->id }}" class="custom-control-input is_active" id="is_active_{{ $item->id }}" name="is_active">
                                             @endif
                                             <label class="custom-control-label is_active_label" for="is_active_{{ $item->id }}" title="{{ auth()->user()->id == $item->id? 'You can\'t block your self!':'' }}" data-toggle="tooltip"> {!! boolval($item->is_active)?" <i class=\"mdi mdi-lock-open-outline  text-success\"></i> Unblock":" <i class=\"mdi mdi-lock text-danger\"></i> Block" !!} </label>
                                        </div>    
                                    </td>
                                    <td>
                                        <a href="{{ url('/' . Config("authorization.route-prefix") . '/users/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"
                                           title="Edit User"><i class="fa fa-edit"></i></a>
        
                                        @if($item->id != Auth::user()->id)
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['/' . Config("authorization.route-prefix") . '/users', $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash"></i>', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete User',
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

    <div id="userForm" class="modal fade" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content" style="width: 700px !important;">
    
                <div class="modal-header" style="background: #5d74a8;">
                    <h5 class="modal-title text-white">User Form</h5>
                    <span aria-hidden="true" data-dismiss="modal"><i class="fa fa-times text-light" style="cursor: pointer;"></i></span>
                </div>

                <form id="userSubmit" action="{{ route('users.create_new_user') }}" method="POST">
                    @csrf
                <div class="modal-body">
    
                    <div class="row my-2">
                           
                        <div class="col-md-6">
                            <div class="form-group content2">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input" name="name" id="name" placeholder="Enter Name">
                                <span class="border"></span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="form-group content2">
                                <label for="email">Email <span class="text-danger">*</span> </label>
                                <input type="email" class="form-control input email" name="email" id="email" placeholder="Enter Email">
                                <span class="border"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group content2">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control input password" name="password" id="password" placeholder="Enter Password.">
                                <span class="border"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group content2">
                                <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control input confirmpassword" id="confirmpassword" placeholder="Enter Password.">
                                <span class="border"></span>
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group custom-control custom-switch">
                                <input type="checkbox" checked class="custom-control-input" id="is_active" name="is_active">
                                <label class="custom-control-label" for="is_active">Status</label>
                            </div>
                        </div>
                    </div>

                </div>
    
                <div class="modal-footer">
                    <div class="wrapper">
                        <i class="fa fa-sync" style="margin-right: 550px; cursor: pointer;"></i>
                        <button class="btn btn-success" id="form-submit"> <i class="fa fa-save"> SAVE</i></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#usersTable').DataTable();
            $('.select2').select2().val(null).trigger('change');
            $('.is_active').bind('change',changeUserStatus);
            $('#create-user').bind('click',openUserForm);
            $(document).on('input', '#email', checkEmailValidation);
            $('#form-submit').bind('click',submitUserForm);
        })

        function changeUserStatus(){
            let is_active_input         = $(this),
                is_active_input_value   = is_active_input.val(),
                is_active_label         = is_active_input.parent().find('.is_active_label'),
                obj = {};
            if(is_active_input.is(":checked")){
                obj.id          = is_active_input_value;
                obj.is_active   = 1;
            }else {
                obj.id          = is_active_input_value;
                obj.is_active   = 0; 
            }

            obj._token = "{{ csrf_token() }}";

            $.ajax({
                url     : "{{ route('users.updateUserStatus') }}",
                method  : "POST",
                data    : obj,
                success : function(res){

                    if(res?.data?.is_active==1){
                        is_active_input.prop('checked',true);
                        is_active_label.html("<i class=\"mdi mdi-lock-open-outline  text-success\"></i> Unblock");
                    }else{
                        is_active_input.prop('checked',false);
                        is_active_label.html("<i class=\"mdi mdi-lock text-danger\"></i> Block");
                    }

                    leaveSuccessMessage(res.msg);
                },
                error   : function(err){
                    console.log(err);
                    leaveErrorMessage(err.responseJSON.msg??null);
                },
            });


        }


        function openUserForm(){
            $("#userSubmit")[0].reset();
            $("#userForm").modal('show');
        }

        function submitUserForm(e){
            e.preventDefault();
            let 
            name            = $('#name').val(),
            email           = $('#email').val(),
            password        = $('#password').val(),
            confirmpassword = $('#confirmpassword').val(),
            is_activeInput  = $('#is_active'),
            _token          = "{{ csrf_token() }}",
            is_active,pattern,regex;

            if(name.trim()==""){
                leaveErrorMessage('Name is Required!');
                return false;
            }

            if(email.trim()==""){
                leaveErrorMessage('Email is Required!');
                return false;
            }

            pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$";
            regex   = new RegExp(pattern);
            if(email.match(pattern)){
                $('#email').removeClass('is-invalid');
            }else {
                $('#email').addClass('is-invalid');
                $('#email').attr('pattern',regex);
                return false;
            }

            if(password.trim()==""){
                leaveErrorMessage('Password is Required!');
                return false;
            }

            if(password!==confirmpassword){
                leaveErrorMessage('Password Missmatch!');
                return false;
            }

            if(is_activeInput.is(":checked")){
                is_active   = 1;
            }else {
                is_active   = 0; 
            }

            $.ajax({
                url     : $('#userSubmit').attr('action'),
                method  : "POST",
                data    : {name,email,password,_token,is_active},
                success : function(res){
                    leaveSuccessMessage(res.msg);
                    $("#userForm").modal('hide');
                    setTimeout(function(){ window.location.reload()},3000);
                },
                error   : function(err){
                    console.log(err);
                    leaveErrorMessage(err.responseJSON.msg??null);
                },
            });
            

        }


        function checkEmailValidation()
        {
            let pattern, regex, email;

            pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$";
            email   = $(this).val();
            regex   = new RegExp(pattern);

            if(email.match(pattern)){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
                $(this).attr('pattern',regex);
            }
            
            $(this).val(email).trigger('change');
        }


    </script>
@endpush