@extends('backend.layouts.master')

@section('title', 'Dashboard')
@push('css') 
<link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/css/dashboard.css') }}">
@endpush


@section('content')
<div class="container-fluid">

	<div class="row mt-3 mb-3">

        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class="fas fa-table"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Total Survey</span>
                <span class="h4 d-block text-uppercase">{{ numOfSurveys() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class="fas fa-users  text-muted dashboard-icon"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Total User</span>
                <span class="h4 d-block text-uppercase">{{ numOfUsers() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col animate">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class=" fas fa-user"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Today's Participant</span>
                <span class="h4 d-block text-uppercase">{{ todays_participant() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        {{-- <iframe src="https://www.cornerstoneondemand.com/" style="width: 400px; height: 200px;"></iframe> --}}

    </div>
</div>

@endsection



@push('js')
<script src="{{ asset('ui/backend/dist/assets/js/animate.js') }}"></script>
<script src="{{ asset('ui/backend/dist/assets/js/dashboard.js') }}"></script>
@endpush
