@extends('backend.layouts.master')
@push('css')
<style>
#myModal .modal-body{
    height: 80vh;
    overflow-y: auto;
}
</style>
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i>  Surveys List
		<button type="button" id="create" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light"><i class="fa fa-plus"></i> Create</button>
	</h4><br>

	<!-- end page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body scroll">
                    <table id="myTable" class="table table-striped table-hover table-bordered text-center nowrap"  cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Survey Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($surveys) && count($surveys)>0)
                                @foreach ($surveys as $survey)
                                    <tr data-status="{{ boolval($survey->is_active) ? 'active': 'inactive' }}" data-json="{{ $survey }}">
                                        <td>{{ $survey->title??'' }}</td>
                                        <td>{{ $survey->start_date??'' }}</td>
                                        <td>{{ $survey->end_date??'' }}</td>
                                        <td><span class="badge badge-info">{{ \Carbon\Carbon::parse($survey->created_at)->diffForHumans()??'' }}</span></td>
                                        <td>
                                            @if(boolval($survey->is_active))
                                            <i class='mdi mdi-record text-success'>Active</i>
                                            @else
                                            <i class='mdi mdi-record text-danger'>Inactive</i>
                                            @endif
                                        </td>
                                        <td class="text-left" data-id="{{ $survey->id }}" style="width: 150px;">
                                            <button class="btn btn-sm btn-info mx-1 edit"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-info mx-1 embaded"><i class="fa fa-clone"></i> Embed</button>
                                            @if(hasVotes($survey->id )>0)
                                            <a href="{{ route('surveys.show',$survey->id) }}" class="btn btn-sm btn-success text-center"><i class="fa fa-eye text-white"></i> Reports</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr class="text-bold">
                                    <td colspan="10" class="dataTables_empty">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- -->
    </div>
    <!-- end page content -->
</div>



<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="width: 700px !important;">

            <div class="modal-header" style="background: #5d74a8;">
                <h5 class="modal-title text-white">Survey Form</h5>
                <span aria-hidden="true" data-dismiss="modal"><i class="fa fa-times text-light" style="cursor: pointer;"></i></span>
            </div>

            <form id="myForm" action="{{ route('surveys.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Survey Name">
                        </div>

                        <div class="form-group">
                            <label for="wel_msg">Welcome Message</label>
                            <textarea name="welcome_msg" id="welcome_msg" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="thanks_msg">Thanks Message</label>
                            <textarea name="thank_msg" id="thanks_msg" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="text" autocomplete="off"  name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="redirect_uri">Redirect Url</label>
                            <input type="text" name="redirect_uri" id="redirect_uri" class="form-control">
                        </div>
                        
                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active">
                            <label class="custom-control-label" for="is_active">Status</label>
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


<div id="myModalEmbed" class="modal fade" data-backdrop="static" data-keyboard="false" aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="width: 700px !important;">

            <div class="modal-header" style="background: #0e53a1;">
                <h5 class="modal-title text-white">Embeded Survey</h5>
                <span aria-hidden="true" data-dismiss="modal"><i class="fa fa-times text-light" style="cursor: pointer;"></i></span>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="survey">Copy</label>
                    <textarea name="survey" id="survey" class="form-control">
                        <iframe src="{{ url('/') }}" width="600" height="450" style="border:0;" loading="lazy"></iframe>
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ui/backend/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
     window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
     $(document).ready(function(){

        CKEDITOR.replace('welcome_msg',{
            width: '100%',
            height:'auto',
            resize_dir: 'vertical',
            resize_maxHeight: 100,
        });

        CKEDITOR.replace('thanks_msg',{
            width: '100%',
            height:'auto',
            resize_dir: 'vertical',
            resize_maxHeight: 100,
        });


        $('#start_date').datepicker({
            todayHighlight  : true,
            format          : 'yyyy-mm-dd',
            startDate       : new Date('2020-01-01'),
            autoclose       : true,
            todayBtn        : true,
        });

        $('#end_date').datepicker({
            todayHighlight  : true,
            format          : 'yyyy-mm-dd',
            startDate       : new Date('2020-01-01'),
            autoclose       : true,
            todayBtn        : true,
        });
        // init select2 with data 

        //eventlistener
        $(document).on('click','#create',showModal);
        $(document).on('click','.edit',editForm);
        $(document).on('click','.embaded',embadedSurvey);

        // init dataTable 
        load_dataTable({
            tableId         : '#myTable',
            lengthMenu      : [15, 25, 50, 75, 100, 250, 500, 1000],
            data            : [],
            columns		    : [],
            // scrollY         : 600,
            // scrollCollapse  : true,
            paging			: true,
            drawCallback    : true,
            fnRowCallback   : true,
            responsive      : true,
            columnDefs      : [],
            order           : [],
            attr            : ['data-surveys']
        });




    });


function embadedSurvey()
{
    $("#myModalEmbed").modal('show');
}    



function showModal()
{
    let route = "{{ route('surveys.store') }}";
    resetForm(route);
    $('#form-method').html( '');
    $("#myModal").modal('show');
}


function editForm()
{
    let rowJson = $(this).closest('tr').attr('data-json');
    let json    = JSON.parse(rowJson);
    let route   = "{{  route('surveys.update','')  }}/"+json.id;
    resetForm(route);
    visibleFormData(json);
    $('#form-method').html( '<input type="hidden" name="_method" value="PUT">');
    $("#myModal").modal('show');
}


function resetForm(route=null)
{
    $('#myForm')[0].reset();
    $('#myForm').attr('action',route);
}


function visibleFormData(data){

    $('#title').val(data.title);
    $('#start_date').val(data.start_date);
    $('#end_date').val(data.end_date);
    $('#redirect_uri').val(data.redirect_uri);
    CKEDITOR.instances['welcome_msg'].setData(data.welcome_msg);
    CKEDITOR.instances['thanks_msg'].setData(data.thank_msg);
    Boolean(data.is_active) ? $('#is_active').prop('checked',true) : $('#is_active').prop('checked',false);
}

</script>

@endpush