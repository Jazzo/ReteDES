<?php


   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    



//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del men? verticale dovr? essere aperta
$r->voce_mv_attiva = menu_lat::anagrafiche;
//Assegno il titolo che compare nella barra delle info
$r->title = "Geo ditte Clustered";


//Dico quale men? orizzontale dovr?? essere associato alla pagina.
$r->menu_orizzontale = ditte_menu_completo(null);
$r->javascripts_header[]='<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
                          <script type="text/javascript" src="'.$RG_addr["js_markercluster"].'"></script>';
$r->javascripts[]='<script type="text/javascript">
                        
                        var bounds = new google.maps.LatLngBounds();
                        var markers = [];
                        var infoList = [];
                        
                        function InfoClose() {
                        if (! infoList.length) { return; }
                        for (i in infoList) {
                           infoList[i].infoWindow.close();
                        }
                        infoList = [];
                        } 
                        
                        var data='.create_json("ditte","SELECT * from retegas_ditte WHERE ditte_gc_lat>0").';
                      
                      function initialize() {
                        var center = new google.maps.LatLng(45.4419, 8.00);

                        var map = new google.maps.Map(document.getElementById(\'map\'), {
                          zoom: 3,
                          center: center,
                          mapTypeId: google.maps.MapTypeId.TERRAIN
                        });
                        
                        
                        for (var i = 0; i < data.dataNRecs; i++) {
                          
                          var dataDitte = data.ditte[i];
                          var latLng = new google.maps.LatLng(dataDitte.objLatitude,dataDitte.objLongitude);
                    
                          var contentTxt = dataDitte.objHtml;
                              
                          var marker = new google.maps.Marker({
                            position: latLng
                          });
                          bounds.extend(latLng);
                          
                          marker.infoWindow = new google.maps.InfoWindow({
                              content: contentTxt
                          });

                           google.maps.event.addListener(marker,\'click\',function() {
                              InfoClose();
                              infoList.push(this);
                              this.infoWindow.open(map,this);
                              $(\'.rateit\').rateit();       
                           });
                          
                          markers.push(marker);
                        }
                        
                        
                        
                        
                        map.fitBounds(bounds);
                        var markerCluster = new MarkerClusterer(map, markers);
                      }
                      google.maps.event.addDomListener(window, \'load\', initialize);
                    </script>';
$r->javascripts_header[] = java_head_rateit();
                    
if(_USER_HAVE_MSG){
    $r->messaggio = _USER_MSG;
    delete_option_text(_USER_ID,"MSG");
}


$h_a ="<h3>Ditte (Raggruppate geograficamente)</h3>
       <div id=\"map\" style=\"width:100%;height:40em;\"></div>";
$h_b = "<div id=\"scheda_ditta\"></div>";


$h = "<div class=\"rg_widget rg_widget_helper\">";
$h.= render_container_table_2($h_a,$h_b,66,33);       
$h.="</div>";

$r->contenuto = $h;                 
//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>