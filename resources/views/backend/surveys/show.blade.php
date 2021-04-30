@extends('backend.layouts.master')
@push('css')
@endpush
@section('content')

<div class="container-fluid">

	<h4 class="page-title text-uppercase mt-3">
		<i class="fab fa-artstation"></i>  Survey Reports
		<button type="button" class="float-right btn btn-sm btn-primary btn-rounded width-md waves-effect waves-light" onclick="window.history.back()"> Back</button>
	</h4><br>

	<!-- end page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <table id="myTable" class="table table-borderless  text-center nowrap"  cellspacing="0" width="100%">
                        <tbody>
                            @if(!is_null($survey_reports) && count($survey_reports)>0)
                                @foreach ($survey_reports as $question)
                                    <tr>
                                        <th>
                                           <div class="px-2 py-2 my-0" style="border-left: 5px solid rgb(131, 175, 194);box-shadow: 0px 2px 2px 0px #83afc27d">
                                            <div class="row w-50 d-flex">
                                                <strong class="font-weight-bold pl-2" style="font-size: 20px;">Question {{ $loop->iteration??'' }}: &nbsp;&nbsp;</strong> 
                                                <strong class="text-primary pl-2 mt-1" style="font-size: 18px;">{{ $question->question??'' }}</strong>
                                            </div>

                                            @php 
                                                $mainVotes = totalVote($question->survey_id, $question->id);
                                                $main = $mainVotes>0?$mainVotes:1;
                                                $percentage =($main*100)/$main;
                                            @endphp

                                            @if(!is_null($question->json_option))
                                                <div class="row w-50 my-2">
                                                    <div class="col-md-12 text-left">
                                                        <strong class="text-dark" style="font-size: 16px;">Total Vote <span class="badge badge-info">{{ $main }}</span></strong>
                                                    </div>
                                                </div>

                                                @foreach (json_decode($question->json_option) as $item)
                                                    @php
                                                    $subVotes = hasSubVotes($question->survey_id, $question->id,$item);
                                                    @endphp
                                                    <div class="row w-50 my-1">
                                                        <div class="col-md-6 text-left">
                                                            <strong class="text-dark" style="font-size: 15px;">{{ $loop->iteration??'' }} ) {{ $item??'' }} <span class="badge badge-primary">{{ $subVotes }}</span></strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="progress" style="height: 15px;">
                                                                <div class="progress-bar progress-bar-striped" style="min-width:20px;width:{{ round(($subVotes*100)/$main,2) }}%"><span style="font-size: 10px;">{{ round(($subVotes*100)/$main,2) }}%</span></div>
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                @endforeach  
                                           @else 
                                            <div class="row w-50 my-2">
                                                <div class="col-md-6 text-left">
                                                    <strong class="text-dark" style="font-size: 18px;">Total Vote <span class="badge badge-info">{{ totalVote($question->survey_id, $question->id) }}</span></strong>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="progress" style="height: 15px;">
                                                        <div class="progress-bar progress-bar-striped" style="min-width:20px; width:{{ round($percentage,2) }}%"><span style="font-size: 10px;">{{ round($percentage,2) }}%</span></div>
                                                    </div> 
                                                </div>
                                            </div>      
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

<script>
     $(document).ready(function(){});

</script>

@endpush