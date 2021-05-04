@extends('backend.layouts.master')
@section('title', 'Questions Re-arrange')
@push('css')
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i> Re-arrange Questions Of {{ !is_null($survey_reports) && count($survey_reports)>0 ? $survey_reports[0]->title : 'Survey' }}
		<button type="button" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light" onclick="window.history.back()"> Back</button>
	</h4><br>

	<!-- end page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <table id="myTable" class="table table-borderless  text-center nowrap"  cellspacing="0" width="100%">
                        <tbody id="tbody">
                            @if(!is_null($survey_reports) && count($survey_reports)>0)
                                @foreach ($survey_reports as $question)
                                    <tr data-surveyid="{{ $question->survey_id??'' }}" data-id="{{ $question->id??'' }}" data-position="{{ $question->position??0 }}">
                                        <th>
                                           <div class="px-2 py-2 my-0" style="border-left: 5px solid rgb(131, 175, 194);box-shadow: 0px 2px 2px 0px #83afc27d">
                                            <div class="row w-50 d-flex">
                                                <strong class="font-weight-bold pl-2 handle" style="font-size: 20px; cursor: move;">Question <span class="qsl">{{ $loop->iteration??'' }}</span>: &nbsp;&nbsp;</strong> 
                                                <strong class="text-primary pl-2 mt-1" style="font-size: 18px;">{{ $question->question??'' }}</strong>
                                            </div>

                                            @if(!is_null($question->json_option))
                                                @foreach (json_decode($question->json_option) as $item)
                                                    <div class="row w-50 my-1">
                                                        <div class="col-md-6 text-left">
                                                            <strong class="text-dark" style="font-size: 15px;">{{ $loop->iteration??'' }} ) {{ $item??'' }}</strong>
                                                        </div>
                                                    </div> 
                                                @endforeach     
                                            @endif
                                           </div>
                                        </th>
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
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>
     $(document).ready(function(){
        $(document).on('mouseover','.handle', function(){
            changeState("#tbody");
        })
     });



function changeState(state)
{

    $(state).sortable({
        handle      : '.handle',
        axis        : "y",
        containment : "parent",
        items       : "> tr",
        tolerance   : "pointer",
        dropOnEmpty : true,
        start       : function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop        : function (event, ui) {
            let 
            survey_id   = '',
            question_id = '',
            positions = [];

            arr=[... $(this).find('tr')];
            arr.forEach((element,i) => {
                    let position= i+1;
                    let tg = $(element).find('.qsl');
                    tg.text(`${position}`);
                    $(element).attr('data-position',position);

                    survey_id   = $(element).attr('data-surveyid');
                    question_id = $(element).attr('data-id');

                    positions.push([Number(question_id),position]);
                    
            });

            ui.item.toggleClass("highlight");    
            sendRequestForUpdateOrder(survey_id,positions);
        },
        update      : function(event, ui)
        {
            console.log('update')
        }
    });
}



function sendRequestForUpdateOrder(survey_id,positions)
{

    $.ajax({
        url     : "{{ route('updateQuestionsOrder') }}",
        type    : 'POST',
        dataType:'JSON',
        data    : {
            survey_id, positions, "_token": "{{ csrf_token() }}"
        },
        success: function (res) {
            console.log(res)
            leaveSuccessMessage(res.msg);
        },
        error: function (err) {
            console.log(err)
            leaveErrorMessage(err.responseJSON.msg??null);
        }
    });
}

</script>

@endpush