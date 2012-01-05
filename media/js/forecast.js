//Kör
$(function(){
	//loadForecast('sweden/kalmar/kalmar');	
	
});

function loadForecast(_url){
	var url2 = 'http://localhost:8888/weather/forecast/' + _url;
	
	$.ajaxSetup({
		url : url2,
		type : "GET",
	});
	$.ajax({
		success : function(data) {
			handleForecastData(data);
		},
		error : function(object, error) {
			console.log(object, error);	
		}
	})	
}

function handleForecastData(data){
	$('#forecast').empty();
	
	$('#forecast').append(data);
	
	if($('.detailsLink').length){
		
		$('.detailsLink').click(function(e) {
			e.preventDefault();
			loadForecast($(this).attr('id'));
		});
	
	}
	
	if($('.goBackLink').length){
		
		$('.goBackLink').click(function(e) {
			e.preventDefault();
			loadForecast($(this).attr('id'));
		});
	
	}
}
