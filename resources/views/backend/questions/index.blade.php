@extends('backend.layouts.master')
@push('css')
<style>
.modal-body{
    height: 80vh;
    overflow-y: auto;
}
</style>
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i>  Questions List
		<a type="button" href="{{ route('questions.create') }}" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light"><i class="fa fa-plus"></i> Create</a>
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
                                <th>Question</th>
                                <th>Step No</th>
                                <th>Is Required</th>
                                <th>Created At</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($questions) && count($questions)>0)
                                @foreach ($questions as $question)
                                    <tr data-status="{{ boolval($question->is_active) ? 'active': 'inactive' }}" data-json="{{ $question }}">
                                        <td>{{ $question->survey->title??'' }}</td>
                                        <td class="text-left">{{ $question->question??'' }}</td>
                                        <td>{{ $question->step_no??'' }}</td>
                                        <td>{!! boolval($question->is_required)?'<span class="fa fa-check-circle text-success"></span>':'<span class="fa fa-times text-danger"></span>' !!}</td>
                                        <td><span class="badge badge-info">{{ \Carbon\Carbon::parse($question->created_at)->diffForHumans()??'' }}</span></td>
                                        <td class="text-center" data-id="{{ $question->id }}">
                                            <a href="{{ route('questions.edit',$question->id) }}"><i class="fa fa-edit"></i></a>
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


@endsection

@push('js')
<script>
     $(document).ready(function(){

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
            attr            : ['data-questions']
        });


    });

</script>

@endpush