function mostrar_help()
{

// get handle to the API upon initialization by enabling the "api" variable
var api = $("div.overlay").overlay({oneInstance: false, api: true});
// open the overlay programatically with this API call
api.load(); 
// retrieve an existing api
api = $("div.overlay").overlay();
	
 //var api = $("#overlay").overlay({expose: '#000', effect: 'apple'}); 
 //api.load();		
}