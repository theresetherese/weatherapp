$(function(){
	// Check for Geolocation support
	if (navigator.geolocation) {
		//Get location
	  	navigator.geolocation.getCurrentPosition(function(position) {
	    	var pos = position;
	    	var latitude = pos['coords']['latitude'];
	    	var longitude = pos['coords']['longitude'];
	    	
	    	loadCoordSearch(latitude, longitude);
	    	
	    	}, function(error) {
		    alert('Error occurred. Error code: ' + error.code);
		    // error.code can be:
		    //   0: unknown error
		    //   1: permission denied
		    //   2: position unavailable (error response from locaton provider)
		    //   3: timed out
		    }
	  	);
	}
	
	$('form').submit(function(e) {
		e.preventDefault();
		loadSearchResults($('#searchInput').val());
	});
});


function loadCoordSearch(_lat, _long){
	var url2 = 'http://localhost:8888/weather/search?lat=' + _lat + '&long=' + _long;
	
	$.ajaxSetup({
		url : url2,
		type : "GET",
	});
	$.ajax({
		success : function(data) {
			loadForecast(data);
		},
		error : function(object, error) {
			console.log(object, error);	
		}
	})	
}

function loadSearchResults(_s){
	var url2 = 'http://localhost:8888/weather/search/' + _s;
	
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

function handleSearchData(data){
	$('#searchResult').empty();
	
	$('#searchResult').append(data);
}
