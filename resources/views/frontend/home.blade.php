@extends('frontend.layouts.master')

@section('content')
<div class="container-fluid px-0" id="home">
    <div class="container-fluid full-height">
        <div class="row row-height">
            <div class="col-md-6 content-left">
                <div class="content-left-wrapper">
                    <!-- /social -->

                    <div lass="container">
                        <figure><img src="{{ asset('img/info_graphic_1.svg') }}" alt="" class="img-fluid"></figure>
                        <h2 class="font-weight-bold">Satisfaction Survey</h2>
                        <p>Tation argumentum et usu, dicit viderer evertitur te has. Eu dictas concludaturque usu, facete detracto patrioque an per, lucilius pertinacia eu vel.Adhuc invidunt duo ex. Eu tantas dolorum ullamcorper qui.</p>
                        <a href="#" class="btn_1 rounded" target="_parent">View More</a>
                    </div>
                </div>
                <!-- /content-left-wrapper -->
            </div>
            <!-- /content-left -->

            <div class="col-md-6 content-right " id="start" style="background: #434bdf;">

                <div class="form-wizard form-header-classic form-body-classic w-100 "  id="embedarea">

                    <form role="form" action="{{ route('answers.store') }}" method="post" id="myForm">
                        @csrf
                        <p class="font-weight-bold">Fill all form field to go next step</p>
                        
                        <!-- Form progress -->
                        <div class="form-wizard-steps form-wizard-tolal-steps-4">
                            <div class="form-wizard-progress">
                                <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                            </div>
                            <!-- Step 1 -->
                            <div class="form-wizard-step active">
                                <div class="form-wizard-step-icon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                <p>Start</p>
                            </div>

                            <div class="form-wizard-step">
                                <div class="form-wizard-step-icon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                <p>Account</p>
                            </div>
                            <!-- Step 1 -->
                            
                            
                            <!-- Step 3 -->
                            <div class="form-wizard-step">
                                <div class="form-wizard-step-icon"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                                <p>Questions</p>
                            </div>
                            <!-- Step 3 -->

                            <div class="form-wizard-step">
                                <div class="form-wizard-step-icon"><i class="fa fa-file-text" aria-hidden="true"></i></div>
                                <p>Finished</p>
                            </div>
                            <!-- Step 4 -->
                        </div>
                        <!-- Form progress -->
                        
                        
                        <!-- Form Step 1 -->
                        <fieldset style="display: block;">
                            <!-- Progress Bar -->
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                              </div>
                            </div>
                            <div class="row ml-1 my-5 justify-content-center">
                                {!! $survey->welcome_msg?? "<h3 class='font-weight-bold'>Welcome To Our Survey APP !</h3>" !!}
                            </div>
                            @isset($survey)
                            <div class="form-wizard-buttons">
                                <button type="button" class="btn btn-next">Next</button>
                            </div>
                            @endisset
                        </fieldset>
                        <!-- Form Step 1 -->

                        <!-- Form Step 2 -->
                        <fieldset>
                            <!-- Progress Bar -->
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                              </div>
                            </div>

                            <ul class="pl-2 mt-2" style="width: 100% !important;">
                                <li class="alert alert-danger d-none" id="errormsg1"></li>
                            </ul>

                            <!-- Progress Bar -->
                            <div class="form-group">
                                <label>Name: <span>*</span></label>
                                <input type="text" name="name" placeholder="Name" class="form-control voter_name required" value="{{ auth()->user()->name ??'' }}">
                            </div>

                            <div class="form-group">
                                <label>Email: <span>*</span></label>
                                <input type="text" name="email" placeholder="Email" class="form-control voter_email required" value="{{ auth()->user()->email ??'' }}">
                            </div>

                            <div class="form-group">
                                <label>Phone: <span>*</span></label>
                                <input type="text" name="phone" placeholder="Phone" class="form-control voter_phone required" value="{{ isset(auth()->user()->voter) ? auth()->user()->voter->phone : '' }}">
                            </div>

                            <div class="form-group">
                                <label>Address: <span>*</span></label>
                                <textarea rows="2" name="address" placeholder="Address" class="form-control voter_address required">{{ isset(auth()->user()->voter) ? auth()->user()->voter->address : '' }}</textarea>
                            </div>
                            
                            <div class="form-wizard-buttons">
                                <button type="button" class="btn btn-previous">Previous</button>
                                <button type="button" class="btn btn-next">Next</button>
                            </div>
                        </fieldset>
                        <!-- Form Step 2 -->

                        <!-- Form Step 3 -->
                        <fieldset>
                            <!-- Progress Bar -->
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                              </div>
                            </div>
                            <!-- Progress Bar -->
                            <div class="row" style="height: 600px;overflow-y: auto;">
                        
                                 <div class="submit step wizard-step ml-2" >
                                     <ul class="pl-2 mt-2" style="width: 109% !important;">
                                         <li class="alert alert-danger d-none" id="errormsg"></li>
                                     </ul>
                                    <h3 class="main_question mt-2">Questions <span> {{ isset($survey->questions) ? count($survey->questions):0 }}</span></h3>
                                    <div class="summary">
                                        <input type="hidden" name="survey_id" value="{{ $survey->id??'' }}" id="survey_id">
                                        <ul data-survey_id="{{ $survey->id??'' }}" class="row questionUl">
                                            @if(isset($survey->questions) && count($survey->questions)>0)
                                            @foreach ($survey->questions as $question)
                                                <li class="col-md-12" data-answer="">
                                                    <h5>{!! $question->question??'' !!}</h5>
                                                    <strong>{{ $loop->iteration }}</strong>
                                                    {!! fetch_editable_options($question->type,$question->json_option,true,$question)??'' !!}
                                                </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <!-- /step-->
                            </div>

                            <div class="form-wizard-buttons">
                                <button type="button" class="btn btn-previous" id="last">Previous</button>
                                <button type="button" class="btn btn-next confirmSubmit" id="confirmSubmit">Submit</button>
                            </div>
                        </fieldset>
                        <!-- Form Step 3 -->

                        <fieldset>
                            <div class="row ml-1 my-4 justify-content-center">
                                {!! $survey->thank_msg?? "<h3 class='font-weight-bold'>Thanks For Everything!</h3>" !!}
                            </div>
                        </fieldset>
                    
                    </form>
                    
                </div>
            </div>
            <!-- /content-right-->
        </div>
        <!-- /row-->
    </div>
</div>

<div class="container px-0 py-5 mb-5">
    <h2 class="text-center my-5 font-weight-bold">
        <span style="border-bottom: 5px solid rgb(171, 197, 194);border-radius:100%" class="py-2">List Of Surveys</span>
    </h2>
    <div class="row">

        @if(count($surveys)>0)
            @foreach ($surveys as $serve)
            <div class="col-md-4 my-2">
                <div class="card shadow" style="height: 300px !important;">
                    <div class="card-body">
                        <h2>{{ $serve->title ?? '' }}</h2>
                        @if(!is_null($serve->description))
                        {!! Str::words($serve->description,50,'.......') !!}
                        <br/>
                        <br/>
                        <a  class="btn btn-sm btn-primary" style="margin-top: 0 !important;" href="{{ route('frontend_show', $serve->id)}}">Read More</a>
                        @else 
                        {{ '' }}
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            {{-- {{ $surveys->links() }} --}}
        @endif
    </div>
</div>

@endsection
