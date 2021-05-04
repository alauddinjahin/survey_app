@extends('frontend.layouts.master')
@section('title', '401-page')

@push('css') 
<style>
	.centerize{
		position:absolute;
		top:50%;
		left:50%;
		transform:translate(-50%,-50%);
	}

	.bg-grey{
		background: rgb(241, 237, 237);
	}
</style>
@endpush

@section('content')
<div class="container-fluid bg-grey text-center mt-5" style="position: relative;height: 92vh !important;">
    <div class="centerize">
        <div class="logo-403">
            <div class="error-text-box ">
                <h1 class="display-1">401</h1>
            </div>
        </div>
        <div class="content-404">
            <h1><b>OPPS!</b> You are Unauthorized.</h1>
            <h4 class="text-muted">You don't have permission to view this page!</h4>
            <button class="btn btn-lg btn-danger" onclick="javascript:window.history.back()">Bring me Back</button>
        </div>
    </div>
</div>
@endsection
