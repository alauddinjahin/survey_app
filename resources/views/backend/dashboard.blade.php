@extends('backend.layouts.master')

@section('title', 'Dashboard')
@push('css') 
<link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/css/dashboard.css') }}">
@endpush


@section('content')
<div class="container-fluid">

	<div class="row mt-3 mb-3">

        <div class="col-12 animate mt-2 col-md-4">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class="fas fa-table"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Total Survey</span>
                <span class="h4 d-block text-uppercase">{{ numOfSurveys() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col-12 animate mt-2 col-md-4">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class="fas fa-users  text-muted dashboard-icon"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Total User</span>
                <span class="h4 d-block text-uppercase">{{ numOfUsers() }}</span>
            </div>
        </div> <!-- .col-md-3 -->
        
        <div class="col-12 animate mt-2 col-md-4">
            <div class="card-box shadow text-center dashboard-link h-100 pt-5">
                <i class=" fas fa-user"></i>
                <span class="h3 d-block text-uppercase font-weight-bold">Today's Participant</span>
                <span class="h4 d-block text-uppercase">{{ todays_participant() }}</span>
            </div>
        </div> <!-- .col-md-3 -->

    </div>

    <div class="">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="lineChart" style="position: relative; height:50vh; width:100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="pieChart" style="position: relative; height:50vh; width:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
</div>

@endsection



@push('js')
<script src="{{ asset('ui/backend/plugins/chartjs/chart.js') }}"></script>
<script src="{{ asset('ui/backend/dist/assets/js/animate.js') }}"></script>
<script src="{{ asset('ui/backend/dist/assets/js/dashboard.js') }}"></script>
<script>
    $(document).ready(function(){
        getMonthlyDataInselectedYear();
    })


    function getMonthlyDataInselectedYear()
    {    
        let items           = @json(month_wise_data());
        const labels        = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const pieChartColors= ['rgb(255, 99, 132)','#5D8AA8','#FFBF00','#A4C639','#FBCEB1','#7FFFD4','#3B444B','#E9D66B','#6D351A','#007FFF','#89CFF0','#CCCCFF'];
        const mainLabel     = 'Total Surveys Report in '+new Date().getFullYear();
    
        const lineChartData = {
            labels: labels,
            datasets: [{
                label: mainLabel,
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: items,
            }]
        };
    
        const lineChartConfig = {
            type    : 'line',
            data    : lineChartData,
            options : {}
        };
    
    
        let lineChart = new Chart(
            document.getElementById('lineChart'),
            lineChartConfig
        );
    
    
    
        // pie chart 
    
        const pieChartData = {
            labels  : labels,
            datasets: [{
                label   : mainLabel,
                data    : items,
                backgroundColor: pieChartColors,
                hoverOffset: 4
            }]
        };
    
    
        const pieChartConfig = {
            type: 'pie',
            data: pieChartData,
            options:{
                responsive:false,
            }
    
        };
    
        let pieChart = new Chart(
            document.getElementById('pieChart'),
            pieChartConfig
        );
    }



   


</script>

@endpush
