//Kör
$(function(){
	
	var data = loadForecast();	
	$('#forecast').append(data);
	
});

function loadForecast(){
	$.ajaxSetup({
		url : "http://localhost:8888/weather/fivedayforecast",
		type : "GET",
	});
	$.ajax({
		success : function(data) {
			presentForecast(data);
		},
		error : function(object, error) {
			console.log(object, error);	
		}
	})	
}

function presentForecast(data){
	$('#forecast').append(data);
}
