/*
Template Name: Minton - Responsive Bootstrap 4 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Dashboard 1
*/

$( document ).ready(function() {
    
	var DrawSparkline = function() {
			$('#sparkline1').sparkline([0, 23, 43, 35, 44, 45, 56, 37, 40], {
					type: 'line',
					width: "100%",
					height: 210,
					chartRangeMax: 50,
					lineColor: '#3f51b5',
					fillColor: 'rgba(63, 81, 181,0.3)',
					highlightLineColor: 'rgba(0,0,0,.1)',
					highlightSpotColor: 'rgba(0,0,0,.2)',
					maxSpotColor:false,
					minSpotColor: false,
					spotColor:false,
					lineWidth: 1
			});

			$('#sparkline1').sparkline([25, 23, 26, 24, 25, 32, 30, 24, 19], {
					type: 'line',
					width: "100%",
					height: '210',
					chartRangeMax: 40,
					lineColor: '#009688',
					fillColor: 'rgba(0, 150, 136, 0.3)',
					composite: true,
					highlightLineColor: 'rgba(0,0,0,.1)',
					highlightSpotColor: 'rgba(0,0,0,.2)',
					maxSpotColor:false,
					minSpotColor: false,
					spotColor:false,
					lineWidth: 1
			});
	
			$('#sparkline2').sparkline([[70,40], [90, 50], [100, 150], [140, 80],[50,90], [80, 120], [130, 80], [90, 70],[80,50], [120, 130], [120, 100], [140, 110]], {
					type: 'bar',
					height: '210',
					barWidth: '15',
					barSpacing: '3',
					stackedBarColor: ['#3f51b5', '#e3eaef']
			});
			
			$('#sparkline3').sparkline([20, 40, 30], {
					type: 'pie',
					width: '210',
					height: '210',
					sliceColors: ['#e3eaef', '#3f51b5', '#009688']
			});
	
			
			};
	
	DrawSparkline();
	
	var resizeChart;

	$(window).resize(function(e) {
			clearTimeout(resizeChart);
			resizeChart = setTimeout(function() {
					DrawSparkline();
			}, 300);
	});
});