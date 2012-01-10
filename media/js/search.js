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
	
	getSearches();
	
	$('form').submit(function(e) {
		e.preventDefault();
		loadSearchResults($('#searchInput').val());
		saveSearch($('#searchInput').val());
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
			handleSearchData(data);
		},
		error : function(object, error) {
			console.log(object, error);	
		}
	})	
}

function handleSearchData(data){
	$('#searchResult').empty();
	
	$('#searchResult').append(data);
	
	$('.chooseLocationLink').click(function(e) {
		e.preventDefault();
		loadForecast($(this).attr('id'));
	});
	
	getSearches();
}

function saveSearch(searchInput){
	//localStorage.setItem(searchInput, searchInput);
	if(localStorage.getItem('weatherSearches'))
	{
		var searches = localStorage.getItem('weatherSearches').split(',');
		var index = jQuery.inArray(searchInput, searches);
		
		if(index >= 0)
		{
			
		}
		else{
			searches.splice(0, 0, searchInput);
			if(searches.length >= 10)
			{
				searches = searches.slice(0,10);
			}
			localStorage.setItem('weatherSearches', searches);
		}
	}
	else{
		localStorage.setItem('weatherSearches', searchInput);
	}
}

function getSearches(){
	$('#latestSearches').empty();
	$('#latestSearches').append('<h3>Latest searches</h3>');
	var searches = localStorage.getItem('weatherSearches').split(',');
	
	if(searches.length > 0){
		$('#latestSearches').append('<ul id="latestSearchesList">');
		for (var i in searches)
		{
			$('#latestSearchesList').append('<li><a href="#" class="latestSearchLink">' + searches[i] + '</a></li>');
		}
		$('#latestSearches').append('</ul>');
	}
	
	$('.latestSearchLink').click(function(e){
		e.preventDefault();
		$('#searchInput').val($(this).text());
		loadSearchResults($(this).text());
	});
}
