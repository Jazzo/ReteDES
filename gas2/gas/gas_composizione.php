<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
include_once ("gas_renderer.php");

// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    

//controlla se l'utente ha i permessi necessari


//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del menÃ¹ verticale dovrÃ  essere aperta
$r->voce_mv_attiva = menu_lat::gas;
//Assegno il titolo che compare nella barra delle info
$r->title = "Composizione proprio GAS";
//Assegno anche la libreria HighCharts
$r->javascripts_header[]=java_head_highcharts();
//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale menÃ¹ orizzontale dovrÃ  essere associato alla pagina.

$r->menu_orizzontale = gas_menu_completo($user);


//Calcolo i valori del grafico

    

   
 //  $o.=       '[\''.substr(strip_tags($ditta),0,30)." ...".'\', '.number_format($totale_ordine,2,",","").'], 
 //  ';
            $ut_attivi .= (int)numero_tipo_utenti_gas(_USER_ID_GAS,1);
            $ut_altri .= (int)amici_quanti_per_gas(_USER_ID_GAS);
            $ut_sospesi .= (int)numero_tipo_utenti_gas(_USER_ID_GAS,2);
            $ut_eliminati .= (int)numero_tipo_utenti_gas(_USER_ID_GAS,3); 
            $ut_attesa .= (int)numero_tipo_utenti_gas(_USER_ID_GAS,0);
 
 
     $o ='[\'Attivi\','.$ut_attivi.'],';
     $o .='[\'Sospesi\','.$ut_sospesi.'],';
     $o .='[\'Amici\','.$ut_altri.'],';
     $o .='[\'In Attesa\','.$ut_attesa.'],';
     $o .='[\'Eliminati\','.$ut_eliminati.']';

//Disegno il grafico
$r->javascripts[]="
                <script type=\"text/javascript\">
               var chart2; 
               $(document).ready(function() {
               chart2 = new Highcharts.Chart({
                chart: {
                    renderTo: 'container2',
                    defaultSeriesType: 'pie',
                    shadow:true
                },
                 credits: {
                        enabled: false
                 },                              
                title : {
                            text: 'Composizione utenti proprio GAS',
                            style: 'font-size:1em;',
                            align: 'left'
                     },
                xAxis: {
                },
                tooltip: {
                     formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.y +' Utenti';
                     }
                  },
                plotOptions: {
                         pie: {
                            size: '80%',
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                               enabled: true,
                               distance: 15,
                               connectorWidth: 1,
                               connectorPadding: 2,
                               formatter: function() {
                                        return this.y +' Utenti';
                                        }
                                          
                            },
                         showInLegend: true
                         }
                      },
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    floating: false,
                    layout: 'horizontal',
                    borderWidth: 0
                },                  
                series: [{
                     type: 'pie',
                     data: [".$o."
                             ]

                  }]
            });
       });
      
      
      </script>
      ";



//Questo Ã¨ il contenuto della pagina
$r->contenuto = '<div style="position:relative; width: 100%; display:table;">
                             <div id="container2" style="width: 100%; height: 30em;   display:table-cell"></div>
                             </div>';
//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>