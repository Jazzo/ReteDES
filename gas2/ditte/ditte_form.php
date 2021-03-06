<?php



   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
include_once ("ditte_renderer.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
	pussa_via();
	exit;     
}    
   
if(ditta_nome($id)==""){
       pussa_via();
}
   
   // ISTANZIO un nuovo oggetto "retegas"

	$retegas = new sito;
	$retegas->posizione = "Ditta n.".$id;
	$ref_table ="output";


	// Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	
	
	// Menu specifico per l'output  

	
	$id_ditta=$id;
	$retegas->menu_sito = ditte_menu_completo($id_ditta);
	//$retegas->menu_sito[]=$h_menu;
 
	// dico a retegas quali sono i fogli di stile che dovr� usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	$retegas->css[]  = "datetimepicker"; 
	  
	// dico a retegas quali file esterni dovr� caricare
	$retegas->java_headers = array("rg");  // editor di testo
		  
	  // creo  gli scripts per la gestione dei menu
	  
	  $retegas->java_scripts_header[] = java_accordion(null,1); // laterale    
	  $retegas->java_scripts_header[] = java_superfish(); 	  
	  //$retegas->java_scripts_bottom_body[] = java_tablesorter($ref_table);
      $retegas->java_scripts_bottom_body[] = java_list_filter();
      
      
       $ditta_gc_lat = db_val_q("id_ditte",$id_ditta,"ditte_gc_lat","retegas_ditte");
       $ditta_gc_lng = db_val_q("id_ditte",$id_ditta,"ditte_gc_lng","retegas_ditte");
       $gas_gc_lat = db_val_q("id_gas",_USER_ID_GAS,"gas_gc_lat","retegas_gas");
       $gas_gc_lng = db_val_q("id_gas",_USER_ID_GAS,"gas_gc_lng","retegas_gas");
      
      
      $retegas->java_scripts_bottom_body[] = '
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

    var location1 = new google.maps.LatLng('.$ditta_gc_lat.', '.$ditta_gc_lng.');
    var location2 = new google.maps.LatLng('.$gas_gc_lat.', '.$gas_gc_lng.');


    var latlng;
    var map;
 
        
    // creates and shows the map
    function showMap()
    {
        // center of the map (compute the mean value between the two locations)
        latlng = new google.maps.LatLng((location1.lat()+location2.lat())/2,(location1.lng()+location2.lng())/2);
        
        // set map options
            // set zoom level
            // set center
            // map type
        var mapOptions = 
        {
            zoom: 1,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        // create a new map object
            // set the div id where it will be shown
            // set the map options
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        
        // show route between the points
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer(
        {
            suppressMarkers: true,
            suppressInfoWindows: true
        });
        directionsDisplay.setMap(map);
        var request = {
            origin:location1, 
            destination:location2,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) 
        {
            if (status == google.maps.DirectionsStatus.OK) 
            {
                directionsDisplay.setDirections(response);
                distance = "La distanza tra il tuo GAS e la ditta � di "+response.routes[0].legs[0].distance.text;
                distance += "<br/>con un tempo di percorrenza di  "+response.routes[0].legs[0].duration.text;
                document.getElementById("distance_road").innerHTML = distance;
            }
        });
        
        // show a line between the two points
        //var line = new google.maps.Polyline({
        //    map: map, 
        //    path: [location1, location2],
        //    strokeWeight: 7,
        //    strokeOpacity: 0.8,
        //    strokeColor: "#FFAA00"
        //});
        
        // create the markers for the two locations        
        var marker1 = new google.maps.Marker({
            map: map, 
            position: location1,
            title: "First location"
        });
        var marker2 = new google.maps.Marker({
            map: map, 
            position: location2,
            title: "Second location"
        });
        
        // create the text to be shown in the infowindows
        var text1 = "'.ditta_nome($id_ditta).'";
                
        var text2 = "'.gas_nome(_USER_ID_GAS).'";
        
        // create info boxes for the two markers
        var infowindow1 = new google.maps.InfoWindow({
            content: text1
        });
        var infowindow2 = new google.maps.InfoWindow({
            content: text2
        });

        // add action events so the info windows will be shown when the marker is clicked
        google.maps.event.addListener(marker1, \'click\', function() {
            infowindow1.open(map,marker1);
        });
        google.maps.event.addListener(marker2, \'click\', function() {
            infowindow2.open(map,marker2);
        });
        
        }
    
    function toRad(deg) 
    {
        return deg * Math.PI/180;
    }
    
    $(document).ready(function() {
        $("#map_canvas").css({
            height: 300
          });
         showMap(); 
  });

    
    
    
</script>';
 
 
	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  $retegas->has_bookmark="SI"; 
	  
	  
			// qui ci va la pagina vera e proria
	   
	  $retegas->content  =  ditte_render_form($id)
                            .listini_render_table_2($ref_table,$id); 
		
	  $html = $retegas->sito_render();
	  echo $html;
	  exit;

	  unset($retegas);	  
	  
	  
	  
?>