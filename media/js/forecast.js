//Kör
$(function(){
	
	loadForecast('sweden/kalmar/kalmar');	
});

function loadForecast(_url){
	var url2 = 'http://localhost:8888/weather/forecast/' + _url;
	
	$.ajaxSetup({
		url : url2,
		type : "GET",
	});
	$.ajax({
		success : function(data) {
			handleData(data);
		},
		error : function(object, error) {
			console.log(object, error);	
		}
	})	
}

function handleData(data){
	$('#forecast').empty();
	
	$('#forecast').append(data);
	
	if($('.detailsLink').length){
		
		$('.detailsLink').click(function() {
			loadForecast($(this).attr('id'));
		});
	
	}
	
	if($('.goBackLink').length){
		
		$('.goBackLink').click(function() {
			loadForecast($(this).attr('id'));
		});
	
	}
}
