@extends('backend.layouts.master')
@section('title', 'Edit Question')
@push('css')
<style>

</style>
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i> Edit Question
		<a type="button" href="{{ route('questions.index') }}" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light">List</a>
	</h4><br>

	<!-- end page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body scroll">
                    <form id="myForm" action="{{ route('questions.update',$question->id) }}" method="POST">
                        <div class="row">
                            <div class="col-md-6 card">
                                @csrf
                                @method('PUT')
                                <div id="form-method"></div>
                                
                                @include('backend.questions.form')

                                <div class="modal-footer">
                                    <div class="wrapper">
                                        <i class="fa fa-sync" style="margin-right: 550px; cursor: pointer;"></i>
                                        <button class="btn btn-success" id="form-submit"> <i class="fa fa-save"> SAVE</i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 card" style="border-left: 5px solid rgb(135, 219, 0)">
                                <h2 class="pl-2">Options:</h2>
                                <div id="options_container">
                                    {!! fetch_editable_options($question->type,$question->json_option)??'' !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- -->
    </div>
    <!-- end page content -->
</div>


@endsection

@push('js')
<script>

     $(document).ready(function(){
        $('.select2').select2().trigger('change');

        $(document).on('change','#question_type',function(){
            let question_type = $(this).val();
            let currentEl     = null;
            switch (question_type) {
                case 'radio':
                    currentEl = renderSingleChoice();
                    break;
                case 'checkbox':
                    currentEl = renderMultipleChoice();
                    break;
                case 'dropdown':
                    currentEl = renderDropdown();
                    break;
                case 'textarea':
                    currentEl = renderTextarea();
                    break;
            }

            $('#options_container').html(currentEl);
        })


        $(document).on('click','.addOptionSingleChoice',function(){
            $('.main-container').append(`
                <div class="form-group handle d-flex">
                    <input name="radio" type="radio" class="w-20 mt-1"/>
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                    <i class="fa fa-times delete text-danger px-2 mt-1" type="button"></i>
                </div>
            `);
        });

        $(document).on('click','.addOptionMultipleChoice',function(){
            $('.main-container-multi').append(`
                <div class="form-group handle d-flex">
                    <input name="checkbox" type="checkbox" class="w-20 mt-1"/>
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                    <i class="fa fa-times delete text-danger px-2 mt-1" type="button"></i>
                </div>
            `);
        });


        $(document).on('click','.addItem',function(){
            let options = [...$('#dropdown').find('option')];
            let inps = '<div class="form-group handle mt-4">';
            $.each(options,function(i,option){
                inps+=`<input type="text" name="json_option[]" class="form-control form-control-sm dropdown-input mt-1" value="${$(option).text()}"/>`;
            })
            inps += `</div>
                <div>
                    <button class="btn btn-sm btn-success save-select pl-2" type="button">Save Selection</button>
                    <button class="btn btn-sm btn-info add-select pl-2" type="button">+ Add</button>
                </div>`;

            $('#dropdown_input_area').html(inps);
        });


        $(document).on('click','.delete',function(){
            $(this).parent().remove();
        });

        $(document).on('click','.save-select',function(){
            let selectInputs = [...$(document).find('.dropdown-input')];
            let selection ='';
            $.each(selectInputs,function(i,input){
                $(input).addClass('d-none');
                selection+=`<option value="">${$(input).val()}</option>`;
            })

            $('#dropdown').html(selection);
            $(this).addClass('d-none');
            $('.add-select').addClass('d-none');
            $('.delete').addClass('d-none');
        });

        $(document).on('click','.add-select',function(){
            let html = `
            <div class="d-flex">
                <input type="text" name="json_option[]" class="form-control form-control-sm dropdown-input mt-1 w-80" value=""/>
                <i class="fa fa-times delete text-danger px-2 mt-1" type="button"></i>
            </div>
            `;
            $('#dropdown_input_area .form-group').append(html);
        });

    });


    function renderSingleChoice()
    {
        return `
            <div class="main-container pl-2">
                <div class="form-group handle d-flex">
                    <input name="radio" type="radio" class="w-20 mt-1" checked />
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                </div>
                <div class="form-group handle d-flex">
                    <input name="radio" type="radio" class="w-20 mt-1"/>
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                </div>
            </div>

            <div class="form-group pl-4">
                <button type="button" class="btn btn-sm btn-info addOptionSingleChoice"> + Add</button>
            </div>
        `;
    }

    function renderMultipleChoice()
    {
        return `
            <div class="main-container-multi pl-2">
                <div class="form-group handle d-flex">
                    <input name="checkbox" type="checkbox" class="w-20 mt-1" checked />
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                </div>
                <div class="form-group handle d-flex">
                    <input name="checkbox" type="checkbox" class="w-20 mt-1"/>
                    <input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value=""/>
                </div>
            </div>

            <div class="form-group pl-4">
                <button type="button" class="btn btn-sm btn-info addOptionMultipleChoice"> + Add</button>
            </div>
        `;
    }


    function renderTextarea()
    {
        return `
            <div class="main-container-textarea pl-2">
                <div class="form-group handle d-flex">
                    <textarea class="form-control" rows="4" disabled>Write Something ...</textarea>
                </div>
            </div>
        `;
    }


    function renderDropdown()
    {
        return `
            <div class="main-container-dropdown pl-2">
                <i class="fa fa-edit addItem text-success float-right px-2 my-2" type="button"></i>
                <select id="dropdown" class="form-control">
                    <option value="">Choice 1</option>
                    <option value="">Choice 2</option>
                </select>

                <div id="dropdown_input_area" class="mt-2"></div>
            </div>
        `;
    }

</script>

@endpush