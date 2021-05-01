@extends('backend.layouts.master')
@section('title', 'Payments')
@push('css')
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i>  Payments List
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
                                <th>Payment Title</th>
                                <th>Payment Description</th>
                                <th>Created At</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($payments) && count($payments)>0)
                                @foreach ($payments as $payment)
                                    <tr data-json="{{ $payment }}">
                                        <td>{{ $payment->title??'' }}</td>
                                        <td>{!! $payment->description??'' !!}</td>
                                        <td><span class="badge badge-info">{{ \Carbon\Carbon::parse($payment->created_at)->diffForHumans()??'' }}</span></td>
                                        <td class="text-center" data-id="{{ $payment->id }}">
                                            <i class="fa fa-edit"></i>
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
                <h5 class="modal-title text-white">Payment Form</h5>
                <span aria-hidden="true" data-dismiss="modal"><i class="fa fa-times text-light" style="cursor: pointer;"></i></span>
            </div>

            <form id="myForm" action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Payment Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
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
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ui/backend/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
     window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
     $(document).ready(function(){

        CKEDITOR.replace('description',{
            width: '100%',
            height:'auto',
            resize_dir: 'vertical',
            resize_maxHeight: 100,
        });

        // init select2 with data 

        //eventlistener
        $(document).on('click','#create',showModal);
        $(document).on('click','.fa-edit',editForm);

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
            attr            : ['data-payments']
        });




    });



function showModal()
{
    let route = "{{ route('payments.store') }}";
    resetForm(route);
    $('#form-method').html( '');
    $("#myModal").modal('show');
}


function editForm()
{
    let rowJson = $(this).closest('tr').attr('data-json');
    let json    = JSON.parse(rowJson);
    let route   = "{{  route('payments.update','')  }}/"+json.id;
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
    CKEDITOR.instances['description'].setData(data.description);
}

</script>

@endpush