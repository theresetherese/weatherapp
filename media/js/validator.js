var validCountryRegionCity = function(s){
	if(s.match(/^[a-zåäö0-9\s]*\/[a-zåäö0-9\s]*\/[a-zåäö0-9\s]*(\/[0-9]{8}\/[01234])?$/i)){
		return true;
	}
	else{
		return false;
	}
};

var validText = function(s){
	if(s.match(/^[a-zåäö0-9\s\/]+$/)){
		return true;
	}
	else{
		return false;
	}
};

var isNumeric = function(s){
	if (isNaN(parseFloat(s))){
		return false;
	}
	else{
		return true;
	}
};
