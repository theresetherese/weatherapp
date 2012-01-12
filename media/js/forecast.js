/*
 * Ajax call to get forecastdata
 * Sends data to handleForecastData()
 */
var loadForecast = function(_url){
	if(validCountryRegionCity(_url)){
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
};

/*
 * Display forecastdata in container
 * Add click event to details-link and goback-link
 */
var handleForecastData = function(data){
	$('#forecast').empty();
	
	$('#forecast').append(data);
	
	favoriteLinks();
	
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
};
